<?php

namespace App\Providers;

use App\Contracts\FileStorageInterface;
use App\Http\Middleware\SetActiveOrganization;
use App\Services\FileStorageService;
use App\Services\LocalStorageService;
use App\Services\S3StorageService;
use App\Singleton\TenantManager;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
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


        // for all apis
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Rate limiter for Lead Capture
        RateLimiter::for('lead-capture', function (Request $request) {
            return [
                Limit::perHour(10)->by('ip:' . $request->ip()),
                Limit::perHour(100)->by('token:' . $request->route('token')),
            ];
        });
    }
}
