<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ObjectSerializer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ObjectSerializer::class, function ($app) {
            return new ObjectSerializer();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
