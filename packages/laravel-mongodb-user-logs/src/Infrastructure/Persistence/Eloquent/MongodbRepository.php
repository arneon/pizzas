<?php

namespace Arneon\MongodbUserLogs\Infrastructure\Persistence\Eloquent;

use Arneon\MongodbUserLogs\Infrastructure\Model\Model;
use Arneon\MongodbUserLogs\Domain\Repository\Repository as MongoRepository;

class MongodbRepository implements MongoRepository
{

    public function create(array $request)
    {
        try {
            $model = Model::create($request);
            return $model->toArray();
        }
        catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function findAll()
    {
        return Model::all()->toArray();
    }
}
