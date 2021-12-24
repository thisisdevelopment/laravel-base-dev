<?php

namespace ThisIsDevelopment\LaravelBaseDev\Providers;

use Illuminate\Support\ServiceProvider;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainAction;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainEvent;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainException;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainModel;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainRepositoryInterface;

class BaseDevServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register the command if we are using the application via the CLI
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeDomainAction::class,
                MakeDomainEvent::class,
                MakeDomainException::class,
                MakeDomainModel::class,
                MakeDomainRepositoryInterface::class
            ]);
        }
    }
}
