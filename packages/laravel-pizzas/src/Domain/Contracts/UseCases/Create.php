<?php

namespace Arneon\LaravelPizzas\Domain\Contracts\UseCases;

interface Create
{
    public function __invoke(array $request): array;
}
