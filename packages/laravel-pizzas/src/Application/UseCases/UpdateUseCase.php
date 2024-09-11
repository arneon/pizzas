<?php

namespace Arneon\LaravelPizzas\Application\UseCases;

use Arneon\LaravelPizzas\Domain\Contracts\UseCases\Update as UseCaseInterface;
use Arneon\LaravelPizzas\Domain\Repositories\Repository;
use Arneon\LaravelPizzas\Domain\Events\EntityPizzaUpdated as EntityUpdated;
use Illuminate\Support\Facades\Event;
class UpdateUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly Repository $repository
    ){}

    public function __invoke(int $id, array $request): array
    {

        try{
            $model = $this->repository->updatePizza($id, $request);
            Event::dispatch(new EntityUpdated($model));
            logger()->info('UpdatePizzaUseCase: ', ['model' => $model]);

            return $model;
        }catch (\Exception $e){
            logger()->error('UpdatePizzaUseCase Error: ', ['error' => $e->getMessage()]);
            return [$e->getMessage()];
        }

    }
}
