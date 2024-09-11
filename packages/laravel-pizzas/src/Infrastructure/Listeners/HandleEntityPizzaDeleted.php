<?php

namespace Arneon\LaravelPizzas\Infrastructure\Listeners;

use Arneon\LaravelPizzas\Domain\Events\EntityPizzaDeleted as EntityDeleted;
use Arneon\LaravelPizzas\Infrastructure\Persistence\Redis\RedisRepository;
class HandleEntityPizzaDeleted
{
    private $redis;
    public function __construct(
        private RedisRepository $redisRepository,
    )
    {
        $this->redis = $redisRepository;

    }
    public function handle(EntityDeleted $event) :void
    {
        $entity = $event->entity;

        $pizzas = $this->redis->deletePizza($entity['id']);

        logger()->info('HandleEntityDeleted: ', ['entity' => $entity]);
    }
}
