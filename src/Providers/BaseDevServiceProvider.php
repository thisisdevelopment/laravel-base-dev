<?php

namespace ThisIsDevelopment\LaravelBaseDev\Providers;

use Illuminate\Support\ServiceProvider;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomain;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainAbstractAction;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainAbstractEvent;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainAction;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainDto;
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
                MakeDomain::class,
                MakeDomainAbstractAction::class,
                MakeDomainAbstractEvent::class,
                MakeDomainAction::class,
                MakeDomainDto::class,
                MakeDomainEvent::class,
                MakeDomainException::class,
                MakeDomainModel::class,
                MakeDomainRepositoryInterface::class,
            ]);
        }
    }
}
