<?php

namespace Arneon\LaravelPizzas\Domain\Events;

class EntityUpdated
{
    public $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }
}
