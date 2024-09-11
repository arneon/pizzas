<?php

namespace Arneon\LaravelPizzas\Application\UseCases;

use Arneon\LaravelPizzas\Domain\Contracts\UseCases\ValidateLogin;
use Arneon\LaravelPizzas\Domain\Repositories\Repository as RepositoryInterface;

class ValidateLoginUseCase implements ValidateLogin
{
    public function __construct(
        private readonly RepositoryInterface $repository,
    )
    {
    }
    public function __invoke(string $email, string $password)
    {
        return $this->repository->validateLogin($email, $password);
    }


}
