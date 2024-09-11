<?php

namespace Arneon\LaravelPizzas\Domain\Events;

class EntityIngredientDeleted
{
    public $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }
}
