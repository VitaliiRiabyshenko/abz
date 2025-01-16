<?php

namespace App\Providers;

use App\Http\Services\Image\TinifyApi;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Image\ImageOptimization;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ImageOptimization::class, function ($app) {
            return new TinifyApi();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::pattern('id', '[0-9]+');
    }
}
