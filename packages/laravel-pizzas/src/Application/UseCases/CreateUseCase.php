<?php

namespace Arneon\LaravelPizzas\Application\UseCases;

use Arneon\LaravelPizzas\Domain\Contracts\UseCases\Create as UseCaseInterface;
use Arneon\LaravelPizzas\Domain\Repositories\Repository;
use Arneon\LaravelPizzas\Domain\Events\EntityPizzaCreated as EntityCreated;
use Illuminate\Support\Facades\Event;

class CreateUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly Repository $repository,
    ){

    }

    public function __invoke(array $request): array
    {
        try{
            $model = $this->repository->createPizza($request);

            Event::dispatch(new EntityCreated($model));
            logger()->info('CreateUseCase: ', ['model' => $model]);

            return $model;
        }catch (\Exception $e){
            logger()->error('CreateUseCase Error: ', ['error' => $e->getMessage()]);
            return [$e->getMessage()];
        }
    }
}
