<?php

namespace Arneon\LaravelGoogleAuth\Application\UseCases;

use Arneon\LaravelGoogleAuth\Domain\Contracts\UseCases\Login as UseCaseInterface;
use Arneon\LaravelGoogleAuth\Domain\Repositories\Repository;
class LoginUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly Repository $repository
    ){}

    public function __invoke(array $request): array
    {
        return $this->repository->login($request);
    }
}
