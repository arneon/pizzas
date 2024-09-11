<?php

namespace Arneon\LaravelPizzas\Domain\Contracts\UseCases;

interface FindById
{
    public function __invoke(int $id): array;
}
