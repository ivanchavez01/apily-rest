<?php
namespace ApilyRest;

use Illuminate\Support\ServiceProvider;

class ApilyRestProvider extends ServiceProvider
{
    public function register()
    {
        // $this->app->singleton(ApilyRest::class, function ($app) {
        //     return new ApilyRest();
        // });
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadViewsFrom(__DIR__.'/views', 'apily');
        $this->loadMigrationsFrom(__DIR__.'database/migrations');
        $this->publishes([
            __DIR__.'/config/apily.php' => config_path('apily.php')
        ]);
    }
}
