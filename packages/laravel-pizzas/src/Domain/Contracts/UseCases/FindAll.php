<?php

namespace Arneon\LaravelPizzas\Domain\Contracts\UseCases;

interface FindAll
{
    public function __invoke(): array;
}
