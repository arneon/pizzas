<?php

namespace Arneon\LaravelPizzas\Domain\Events;

class EntityPizzaDeleted
{
    public $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }
}
