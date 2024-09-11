<?php

namespace Arneon\LaravelPizzas\Domain\Contracts\UseCases;

interface FindByField
{
    public function __invoke(string $field, mixed $fieldValue): array;
}
