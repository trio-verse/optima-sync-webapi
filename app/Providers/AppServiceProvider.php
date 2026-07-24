<?php

namespace App\Providers;

use App\Contracts\FileStorageInterface;
use App\Services\FileStorageService;
use App\Services\LocalStorageService;
use App\Services\S3StorageService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') !== 'local' || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
        }
    }
}
