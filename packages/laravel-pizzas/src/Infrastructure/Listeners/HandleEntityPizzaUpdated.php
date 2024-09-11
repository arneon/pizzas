<?php

namespace Arneon\LaravelPizzas\Infrastructure\Listeners;

use Arneon\LaravelPizzas\Domain\Events\EntityPizzaUpdated as EventEntity;
use Arneon\LaravelPizzas\Infrastructure\Models\Pizza;
use Arneon\LaravelPizzas\Infrastructure\Persistence\Redis\RedisRepository;
use Arneon\LaravelPizzas\Infrastructure\Helpers\PizzasHelper;
class HandleEntityPizzaUpdated
{
    use PizzasHelper;
    private $redis;
    public function __construct(
        private RedisRepository $redisRepository
    )
    {
        $this->redis = $redisRepository;

    }
    public function handle(EventEntity $event) :void
    {
        $entity = $event->entity;
        $pizzaModel = Pizza::find($entity['id']);
        $pizzaRedis = $this->buildPizzaArray($pizzaModel);
        $this->redis->updatePizza($entity['id'], $pizzaRedis);

        logger()->info('HandleEntityUpdated: ', ['entity' => $entity]);
    }
}
