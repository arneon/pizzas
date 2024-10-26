<?php

namespace Arneon\MongodbUserLogs\Infrastructure\Controller;

use Arneon\MongodbUserLogs\Infrastructure\Request\CreateLogRequest as CreateRequest;
use Arneon\MongodbUserLogs\Application\UseCase\FindAllUseCase;
use Arneon\MongodbUserLogs\Application\UseCase\CreateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MongodbLogController
{
    public function __construct(
        private readonly FindAllUseCase $findAllUseCase,
        private readonly CreateUseCase $createUseCase,
    )
    {
    }
    public function findAll()
    {
        try {
            return response()->json(['data' => $this->findAllUseCase->__invoke()]);
        }catch (\Exception $e){
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }
    }
    public function create(Request $request) : JsonResponse
    {
        try{
            $createRequest = new CreateRequest($request);
            $validatedData = $createRequest->__invoke();
        }
        catch (\Exception $e){
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }

        try {
            return response()->json(['data' => $this->createUseCase->__invoke($request->all())]);
        }catch (\Exception $e)
        {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 500);
        }
    }

}
