<?php

namespace Arneon\MongodbUserLogs\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Arneon\MongodbUserLogs\Domain\Repository\Repository;
use Arneon\MongodbUserLogs\Infrastructure\Persistence\Eloquent\MongodbRepository;
use Arneon\MongodbUserLogs\Infrastructure\Controller\MongodbLogController;

class PackageServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('MongodbLog', function() {
            return app(MongodbLogController::class);
        });

        $this->app->bind(Repository::class, MongodbRepository::class);
    }
    public function boot()
    {
        // Publish the config file
        $this->publishes([
            __DIR__ . '/../../../config/mongodb-user-logs.php' => config_path('arneon-mongodb-user-logs.php'),
        ], 'config');
        // Merge default config in case the user does not publish the config
        $this->mergeConfigFrom(
            __DIR__ . '/../../../config/mongodb-user-logs.php', 'arneon-mongodb-user-logs'
        );

        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/Api.php');

        $this->publishes([
            __DIR__ . '/../../../tests' => base_path('/tests/arneon-user-mongodb-logs'),
        ], 'tests');

        $this->loadViewsFrom(__DIR__ . '/../Views', 'arneon/laravel-user-mongodb-logs');
        $this->publishes([
            __DIR__ . '/../Views' => resource_path('views/vendor/arneon/laravel-user-mongodb-logs'),
        ], 'views');
    }
}
