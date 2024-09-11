<?php

namespace Arneon\LaravelPizzas\Application\UseCases;

use Arneon\LaravelPizzas\Domain\Contracts\UseCases\Register as UseCaseInterface;
use Arneon\LaravelPizzas\Domain\Repositories\Repository;
class RegisterUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly Repository $repository
    ){}

    public function __invoke(array $request): array
    {
        return $this->repository->register($request);
    }
}
