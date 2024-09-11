<?php

namespace Arneon\LaravelPizzas\Application\UseCases;

use Arneon\LaravelPizzas\Domain\Contracts\UseCases\Delete as UseCaseInterface;
use Arneon\LaravelPizzas\Domain\Repositories\Repository;
use Arneon\LaravelPizzas\Domain\Events\EntityPizzaDeleted as EntityDeleted;
use Illuminate\Support\Facades\Event;


class DeleteUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly Repository $repository
    ){}

    public function __invoke(int $id): array
    {
        Event::dispatch(new EntityDeleted(['id' => $id]));

        $model = $this->repository->deletePizza($id);

        logger()->info('DeletePizzaUseCase: ', ['id' => $id]);

        return [
            'message' => "Pizza deleted successfully",
        ];
    }
}
