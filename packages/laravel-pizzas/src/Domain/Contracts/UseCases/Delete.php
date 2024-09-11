<?php

namespace Arneon\LaravelPizzas\Domain\Contracts\UseCases;

interface Delete
{
    public function __invoke(int $id): array;
}
