<?php

namespace ThisIsDevelopment\LaravelBaseDev\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomain;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainAbstractAction;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainAbstractEvent;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainAction;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainDto;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainEvent;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainException;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainModel;
use ThisIsDevelopment\LaravelBaseDev\Commands\MakeDomainRepositoryInterface;
use ThisIsDevelopment\LaravelBaseDev\Helpers\SQLiteConnection;

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

    public function register()
    {
        /**
         * SQlite does not natively support JSON_CONTAINS, however it allows to define a UDF in
         * php which implements that functionality.
         * In order to "convince" laravel that our SQLite now does support JSON_CONTAINS we need a
         * custom connection + grammar, our SQLiteConnection does exactly that.
         */
        Connection::resolverFor('sqlite', function ($connection, $database, $prefix, $config) {
            $conn = new SQLiteConnection($connection, $database, $prefix, $config);
            $conn->addJsonContainsFunction();
            return $conn;
        });
    }
}
