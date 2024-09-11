<?php

namespace Arneon\LaravelPizzas\Application\UseCases;

use Arneon\LaravelPizzas\Domain\Contracts\UseCases\FindByField;
use Arneon\LaravelPizzas\Domain\Repositories\Repository as RepositoryInterface;
class FindByFieldUseCase implements FindByField
{
    public function __construct(
        private readonly RepositoryInterface $repository,
    )
    {
    }
    public function __invoke(string $field, mixed $fieldValue): array
    {
        return $this->repository->findByField($fieldValue, $field);
    }


}
