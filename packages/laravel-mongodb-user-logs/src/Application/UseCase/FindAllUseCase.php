<?php

namespace Arneon\MongodbUserLogs\Application\UseCase;

use Arneon\MongodbUserLogs\Domain\UseCase\FindAll;
use Arneon\MongodbUserLogs\Domain\Repository\Repository as RepositoryInterface;
class FindAllUseCase implements FindAll
{
    public function __construct(
        private readonly RepositoryInterface $repository,
    )
    {
    }
    public function __invoke(): array
    {
        return $this->repository->findAll();
    }


}
