<?php

namespace Arneon\LaravelPizzas\Infrastructure\Listeners;

use Arneon\LaravelPizzas\Domain\Events\EntityPizzaCreated as EntityCreated;
use Arneon\LaravelPizzas\Infrastructure\Models\Pizza;
use Arneon\LaravelPizzas\Infrastructure\Persistence\Redis\RedisRepository;
use Arneon\LaravelPizzas\Infrastructure\Helpers\PizzasHelper;

class HandleEntityPizzaCreated
{
    use PizzasHelper;
    private $redis;
    public function __construct(
        private readonly RedisRepository $redisRepository,
    )
    {
        $this->redis = $redisRepository;
    }

    public function handle(EntityCreated $event) :void
    {
        $entity = $event->entity;
        $pizzaModel = Pizza::find($entity['id']);
        $pizzaRedis = $this->buildPizzaArray($pizzaModel);
        $this->redis->createPizza($pizzaRedis);

        logger()->info('HandleEntityCreated: ', ['entity' => $entity]);
    }
}
