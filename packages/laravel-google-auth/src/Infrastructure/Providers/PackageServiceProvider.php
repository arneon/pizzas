<?php

namespace Arneon\LaravelGoogleAuth\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Arneon\LaravelGoogleAuth\Domain\Repositories\Repository;
use Arneon\LaravelGoogleAuth\Infrastructure\Persistence\Eloquent\EloquentRepository;

class PackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Repository::class, EloquentRepository::class);
    }
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/Api.php');

        $this->publishes([
            __DIR__ . '/../../../tests' => base_path('/tests/laravel-google-auth'),
        ], 'tests');
    }
}
