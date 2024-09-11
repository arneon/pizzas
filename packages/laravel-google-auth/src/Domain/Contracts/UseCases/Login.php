<?php

namespace Arneon\LaravelGoogleAuth\Domain\Contracts\UseCases;

interface Login
{
    public function __invoke(array $request): array;
}
