<?php

namespace Arneon\LaravelPizzas\Application\UseCases;

use Arneon\LaravelPizzas\Domain\Contracts\UseCases\Update as UseCaseInterface;
use Arneon\LaravelPizzas\Domain\Repositories\Repository;
use Arneon\LaravelPizzas\Domain\Events\EntityUpdated;
use Illuminate\Support\Facades\Event;
class UpdateIngredientUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly Repository $repository
    ){}

    public function __invoke(int $id, array $request): array
    {
        $model = $this->repository->updateIngredient($id, $request);

        Event::dispatch(new EntityUpdated($model));
        logger()->info('UpdateIngredientUseCase: ', ['model' => $model]);

        return $model;
    }
}
