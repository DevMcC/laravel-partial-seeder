<?php

namespace DevMcC\LaravelPartialSeeder;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider
{
    /**
     * Perform post-0registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\MakeSeeder::class,
            ]);
        }
    }
}
