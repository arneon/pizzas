<?php

namespace Arneon\LaravelPizzas\Application\UseCases;

use Arneon\LaravelPizzas\Domain\Contracts\UseCases\Create as UseCaseInterface;
use Arneon\LaravelPizzas\Domain\Repositories\Repository;

class CreateIngredientUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly Repository $repository,
    )
    {

    }

    public function __invoke(array $request): array
    {
        try {
            $model = $this->repository->createIngredient($request);

            logger()->info('CreateIngredientUseCase: ', ['model' => $model]);

            return $model;
        } catch (\Exception $e) {
            logger()->error('CreateIngredientUseCase Error: ', ['error' => $e->getMessage()]);
            return [$e->getMessage()];
        }
    }
}
