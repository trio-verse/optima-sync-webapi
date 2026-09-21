<?php

namespace App\Providers;

use App\Contracts\AffectsProjectCost;
use App\Contracts\FileStorageInterface;
use App\Events\EmployeeHourlyCostChanged;
use App\Events\ProjectEmployeeAssigned;
use App\Events\ProjectEmployeePointsUpdated;
use App\Events\ProjectEmployeeRemoved;
use App\Http\Middleware\SetActiveOrganization;
use App\Listeners\RecalculateProjectCostListener;
use App\Services\FileStorageService;
use App\Services\LocalStorageService;
use App\Services\S3StorageService;
use App\Singleton\TenantManager;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $storage = config('filesystems.default') === 's3'
        //    ? S3StorageService::class
        //    : LocalStorageService::class;

        $this->app->bind(FileStorageInterface::class, FileStorageService::class);


        // Register TenantManager service as a singleton
        $this->app->singleton(TenantManager::class, function ($app) {
            return new TenantManager();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') !== 'local' || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
        }

        /**
         *  any future event that implements AffectsProjectCost will automatically
         *  be caught by RecalculateProjectCostListener with zero additional registration
         */
        Event::listen(AffectsProjectCost::class, RecalculateProjectCostListener::class);


        // for all apis
        $this->applyRateLimiting();

        // Rate limiter for Lead Capture
        RateLimiter::for('lead-capture', function (Request $request) {
            return [
                Limit::perHour(10)->by('ip:' . $request->ip()),
                Limit::perHour(100)->by('token:' . $request->route('token')),
            ];
        });
    }

    public function applyRateLimiting(): void
    {
        //  Dynamic limits based on user tier
        RateLimiter::for('tiered-api', function (Request $request) {
            $user = $request->user();

            if (!$user) {
                // Anonymous users get strict limits
                return Limit::perMinute(10)->by($request->ip());
            }

            // Map subscription tiers to request limits  (feaute update)
            $limits = [
                'free' => 60,
                'starter' => 500,
                'professional' => 2000,
                'enterprise' => 10000,
            ];

            // $maxRequests = $limits[$user->subscription_tier] ?? 100;
            $maxRequests = 60;

            return Limit::perMinute($maxRequests)->by($user->id);
        });

        // Different limits per endpoint type
        RateLimiter::for('resource-based', function (Request $request) {
            // Heavy operations get stricter limits
            $expensiveEndpoints = ['/api/reports', '/api/exports', '/api/bulk'];

            $isExpensive = collect($expensiveEndpoints)
                ->contains(fn($path) => str_starts_with($request->path(), ltrim($path, '/')));

            if ($isExpensive) {
                return Limit::perHour(10)->by($request->user()?->id ?: $request->ip());
            }

            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
