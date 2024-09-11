<?php

namespace Arneon\LaravelPizzas\Infrastructure\Listeners;

use Arneon\LaravelPizzas\Domain\Events\EntityUpdated;
use Arneon\LaravelPizzas\Infrastructure\Models\Pizza;
use Arneon\LaravelPizzas\Infrastructure\Persistence\Redis\RedisRepository;
use Arneon\LaravelPizzas\Infrastructure\Persistence\Eloquent\EloquentRepository;
use Arneon\LaravelPizzas\Infrastructure\Helpers\PizzasHelper;


class HandleEntityIngredientUpdated
{
    use PizzasHelper;
    private $redis;
    private $eloquent;
    public function __construct(
        private RedisRepository $redisRepository,
        private EloquentRepository $eloquentRepository,
    )
    {
        $this->redis = $redisRepository;
        $this->eloquent = $eloquentRepository;

    }
    public function handle(EntityUpdated $event) :void
    {
        $entity = $event->entity;

        $pizzas = $this->eloquent->findPizzasByIngredient($entity['id']);

        foreach ($pizzas as $pizza) {
            $pizzaRedis = $this->buildPizzaArray($pizza);
            $this->redis->updatePizza($pizza->id, $pizzaRedis);
        }

        logger()->info('HandleEntityIngredientUpdated: ', ['entity' => $entity]);
    }
}
