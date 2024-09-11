<?php

namespace Arneon\LaravelPizzas\Domain\Events;

class EntityPizzaCreated
{
    public $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }
}
