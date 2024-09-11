<?php

namespace Arneon\LaravelPizzas\Infrastructure\Listeners;

use Arneon\LaravelPizzas\Domain\Events\EntityIngredientDeleted as EntityDeleted;
use Arneon\LaravelPizzas\Infrastructure\Models\Pizza;
use Arneon\LaravelPizzas\Infrastructure\Persistence\Redis\RedisRepository;
use Arneon\LaravelPizzas\Infrastructure\Persistence\Eloquent\EloquentRepository;
use Arneon\LaravelPizzas\Infrastructure\Helpers\PizzasHelper;


class HandleEntityIngredientDeleted
{
    use PizzasHelper;
    private $redis;
    private $eloquent;
    public function __construct(
        private readonly RedisRepository $redisRepository,
        private readonly EloquentRepository $eloquentRepository,
    )
    {
        $this->redis = $redisRepository;
        $this->eloquent = $eloquentRepository;

    }
    public function handle(EntityDeleted $event) :void
    {
        $entity = $event->entity;

        $pizzas = $this->eloquentRepository->findAllPizzas();
        $pizzasRedis = [];

        foreach ($pizzas as $pizza) {
            $pizzasRedis[] = $this->buildPizzaArray($pizza);
        }

        if($this->redis->replacePizzas($pizzasRedis))
        {
            $message = ['entity' => $entity];
            logger()->info('HandleEntityIngredientDeleted: ', $message);
        }
        else{
            $message = ['entity' => 'ERROR'];
            logger()->error('HandleEntityIngredientDeleted ERROR: ', $message);
        }
    }
}
