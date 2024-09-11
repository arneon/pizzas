<?php

namespace Arneon\LaravelPizzas\Application\UseCases;

use Arneon\LaravelPizzas\Domain\Contracts\UseCases\FindById;
use Arneon\LaravelPizzas\Domain\Repositories\Repository as RepositoryInterface;
class FindPizzaByIdUseCase implements FindById
{
    public function __construct(
        private readonly RepositoryInterface $repository,
    )
    {
    }
    public function __invoke(int $id): array
    {
        return $this->repository->findPizzaById($id);
    }


}
