<?php

namespace Arneon\LaravelPizzas\Application\UseCases;

use Arneon\LaravelPizzas\Domain\Contracts\UseCases\FindAll;
use Arneon\LaravelPizzas\Domain\Repositories\Repository as RepositoryInterface;
class FindAllIngredientsUseCase implements FindAll
{
    public function __construct(
        private readonly RepositoryInterface $repository,
    )
    {
    }
    public function __invoke(): array
    {
        return $this->repository->findAllIngredients();
    }


}
