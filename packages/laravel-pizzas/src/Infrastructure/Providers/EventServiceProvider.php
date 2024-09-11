<?php

namespace Arneon\LaravelPizzas\Infrastructure\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Arneon\LaravelPizzas\Domain\Events\EntityPizzaCreated;
use Arneon\LaravelPizzas\Infrastructure\Listeners\HandleEntityPizzaCreated;
use Arneon\LaravelPizzas\Domain\Events\EntityPizzaDeleted;
use Arneon\LaravelPizzas\Infrastructure\Listeners\HandleEntityPizzaDeleted;
use Arneon\LaravelPizzas\Domain\Events\EntityPizzaUpdated;
use Arneon\LaravelPizzas\Infrastructure\Listeners\HandleEntityPizzaUpdated;

use Arneon\LaravelPizzas\Domain\Events\EntityUpdated;
use Arneon\LaravelPizzas\Infrastructure\Listeners\HandleEntityIngredientUpdated;
use Arneon\LaravelPizzas\Domain\Events\EntityIngredientDeleted;
use Arneon\LaravelPizzas\Infrastructure\Listeners\HandleEntityIngredientDeleted;

class EventServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Event::listen(
            EntityPizzaCreated::class,
            HandleEntityPizzaCreated::class
        );
        Event::listen(
            EntityPizzaDeleted::class,
            HandleEntityPizzaDeleted::class
        );
        Event::listen(
            EntityPizzaUpdated::class,
            HandleEntityPizzaUpdated::class
        );

        Event::listen(
            EntityUpdated::class,
            HandleEntityIngredientUpdated::class
        );

        Event::listen(
            EntityIngredientDeleted::class,
            HandleEntityIngredientDeleted::class
        );
    }
}
