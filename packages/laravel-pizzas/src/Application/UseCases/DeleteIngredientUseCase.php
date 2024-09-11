<?php

namespace Arneon\LaravelPizzas\Application\UseCases;

use Arneon\LaravelPizzas\Domain\Contracts\UseCases\Delete as UseCaseInterface;
use Arneon\LaravelPizzas\Domain\Repositories\Repository;
use Arneon\LaravelPizzas\Domain\Events\EntityIngredientDeleted as EntityDeleted;
use Illuminate\Support\Facades\Event;


class DeleteIngredientUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly Repository $repository
    ){}

    public function __invoke(int $id): array
    {
        try{
            Event::dispatch(new EntityDeleted(['id' => $id]));

            $model = $this->repository->deleteIngredient($id);

            logger()->info('DeleteIngredientUseCase: ', ['id' => $id]);

            return ['message' => 'ingredient deleted successfully'];
        }catch (\Exception $e){
            logger()->error($e);
            throw new \Exception($e->getMessage());
        }

    }
}
