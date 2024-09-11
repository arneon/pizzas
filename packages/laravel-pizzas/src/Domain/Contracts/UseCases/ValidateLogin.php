<?php

namespace Arneon\LaravelPizzas\Domain\Contracts\UseCases;

interface ValidateLogin
{
    public function __invoke(string $email, string $password);
}
