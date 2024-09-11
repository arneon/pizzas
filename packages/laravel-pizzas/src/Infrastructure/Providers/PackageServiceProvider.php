<?php

namespace Arneon\LaravelPizzas\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Arneon\LaravelPizzas\Domain\Repositories\Repository;
use Arneon\LaravelPizzas\Infrastructure\Persistence\Eloquent\EloquentRepository;
use Arneon\LaravelPizzas\Infrastructure\Persistence\Redis\RedisRepository;

class PackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Repository::class, function ($app) {
            return new EloquentRepository();
        });

        $this->app
            ->when(\Arneon\LaravelPizzas\Application\UseCases\FindAllUseCase::class)
            ->needs(Repository::class)
            ->give(RedisRepository::class);

    }
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/Api.php');

        $this->publishes([
            __DIR__ . '/../../../tests' => base_path('/tests/laravel-pizzas'),
        ], 'tests');

        $this->loadViewsFrom(__DIR__ . '/../Views', 'arneon/laravel-pizzas');
        $this->publishes([
            __DIR__ . '/../Views' => resource_path('views/vendor/arneon/laravel-pizzas'),
        ], 'views');

    }
}
