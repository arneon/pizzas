<?php

namespace Arneon\LaravelPizzas\Domain\Contracts\UseCases;

interface Register
{
    public function __invoke(array $request): array;
}
