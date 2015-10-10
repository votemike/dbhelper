<?php

namespace Votemike\Dbhelper;

use Illuminate\Support\ServiceProvider;

class DbhelperServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }
        $this->loadViewsFrom(__DIR__ . '/../views', 'dbhelper');
        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/votemike/dbhelper'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Votemike\Dbhelper\DbHelperController');
    }
}