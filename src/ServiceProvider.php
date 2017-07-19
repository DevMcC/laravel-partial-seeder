<?php

namespace DevMcC\LaravelPartialSeeder;

use DevMcC\LaravelPartialSeeder\Commands\InstallPartialSeederCommand;
use DevMcC\LaravelPartialSeeder\Commands\PartialSeederMakeCommand;
use DevMcC\LaravelPartialSeeder\Commands\SeedPartialSeederCommand;
use DevMcC\LaravelPartialSeeder\Commands\StatusPartialSeederCommand;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
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
                InstallPartialSeederCommand::class,
                PartialSeederMakeCommand::class,
                SeedPartialSeederCommand::class,
                StatusPartialSeederCommand::class,
            ]);
        }
    }
}
