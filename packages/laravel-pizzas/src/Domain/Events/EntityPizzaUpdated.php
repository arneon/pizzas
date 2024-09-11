<?php

namespace Arneon\LaravelPizzas\Domain\Events;

class EntityPizzaUpdated
{
    public $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }
}
