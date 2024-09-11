<?php

namespace Arneon\LaravelPizzas\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Arneon\LaravelPizzas\Application\UseCases\FindAllUseCase;
use Arneon\LaravelPizzas\Application\UseCases\FindPizzaByIdUseCase;
use Arneon\LaravelPizzas\Application\UseCases\CreateUseCase;
use Arneon\LaravelPizzas\Infrastructure\Requests\CreateRequest;
use Arneon\LaravelPizzas\Application\UseCases\UpdateUseCase;
use Arneon\LaravelPizzas\Infrastructure\Requests\UpdateRequest;
use Arneon\LaravelPizzas\Application\UseCases\DeleteUseCase;
use Arneon\LaravelPizzas\Infrastructure\Requests\DeleteRequest;

use Arneon\LaravelPizzas\Application\UseCases\FindAllIngredientsUseCase;
use Arneon\LaravelPizzas\Application\UseCases\CreateIngredientUseCase;
use Arneon\LaravelPizzas\Infrastructure\Requests\CreateIngredientRequest;
use Arneon\LaravelPizzas\Application\UseCases\UpdateIngredientUseCase;
use Arneon\LaravelPizzas\Infrastructure\Requests\UpdateIngredientRequest;
use Arneon\LaravelPizzas\Application\UseCases\DeleteIngredientUseCase;
use Arneon\LaravelPizzas\Infrastructure\Requests\DeleteIngredientRequest;
use Illuminate\Http\Request;

class PizzaController
{
    public function __construct(
        private readonly FindPizzaByIdUseCase $findPizzaByIdUseCase,
        private readonly FindAllUseCase $findAllUseCase,
        private readonly CreateUseCase $createUseCase,
        private readonly UpdateUseCase $updateUseCase,
        private readonly DeleteUseCase  $deleteUseCase,
        private readonly FindAllIngredientsUseCase $findAllIngredientsUseCase,
        private readonly CreateIngredientUseCase $createIngredientUseCase,
        private readonly UpdateIngredientUseCase $updateIngredientUseCase,
        private readonly DeleteIngredientUseCase  $deleteIngredientUseCase,
    )
    {
    }

    public function listPizzas()
    {
        try {
            return response()->json(['data' => $this->findAllUseCase->__invoke()]);
        }catch (\Exception $e){
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }
    }

    public function findPizza(int $id)
    {
        try {
            return response()->json(['data' => $this->findPizzaByIdUseCase->__invoke($id)]);
        }catch (\Exception $e){
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }
    }

    public function createPizza(Request $request) : JsonResponse
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

    public function updatePizza(Request $request, int $id) : JsonResponse
    {
        try {
            $updateRequest = new UpdateRequest($id, $request);
            $validatedData = $updateRequest->__invoke();
        }catch (\Exception $e)
        {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }

        try {
            return response()->json(['data' => $this->updateUseCase->__invoke($id, $request->all())]);
        }catch(\Exception $e)
        {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 500);
        }
    }
    public function deletePizza(mixed $id, Request $request) : JsonResponse
    {
        try{
            $deleteRequest = new DeleteRequest($id, $request);
            $validatedData = $deleteRequest->__invoke();
        }
        catch (\Exception $e){
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }

        try {
            return response()->json(['data' => $this->deleteUseCase->__invoke($id)]);
        }catch(\Exception $e)
        {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }
    }


    public function listIngredients()
    {
        try {
            $ingredients = $this->findAllIngredientsUseCase->__invoke();
            $server_fqdn = env('SERVER_FQDN');

            return view('arneon/laravel-pizzas::admin_ingredients', compact(['ingredients', 'server_fqdn']));
        }catch (\Exception $e){
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }
    }

    public function createIngredient(Request $request) : JsonResponse
    {
        try{
            $createIngredientRequest = new CreateIngredientRequest($request);
            $validatedData = $createIngredientRequest->__invoke();
        }
        catch (\Exception $e){
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }

        try {
            return response()->json(['data' => $this->createIngredientUseCase->__invoke($validatedData)]);
        }catch (\Exception $e)
        {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 500);
        }
    }

    public function updateIngredient(Request $request, int $id) : JsonResponse
    {
        try {
            $updateRequest = new UpdateIngredientRequest($id, $request);
            $validatedData = $updateRequest->__invoke();
        }catch (\Exception $e)
        {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }

        try {
            return response()->json(['data' => $this->updateIngredientUseCase->__invoke($id, $validatedData)]);
        }catch(\Exception $e)
        {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 500);
        }
    }

    public function deleteIngredient(Request $request, int $id) : JsonResponse
    {
        try {
            $deleteRequest = new DeleteIngredientRequest($id, $request);
            $validatedData = $deleteRequest->__invoke();
        }catch (\Exception $e)
        {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }

        try {
            return response()->json(['data' => $this->deleteIngredientUseCase->__invoke($id)]);
        }catch(\Exception $e)
        {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 500);
        }
    }

    public function customerPizzas()
    {
        $pizzas = $this->findAllUseCase->__invoke();
        $ingredients = $this->findAllIngredientsUseCase->__invoke();
        $server_fqdn = env('SERVER_FQDN');

        return view('arneon/laravel-pizzas::customer_pizzas', compact(['pizzas', 'ingredients', 'server_fqdn']));
    }

    public function adminPizzas()
    {
        $pizzas = $this->findAllUseCase->__invoke();
        $ingredients = $this->findAllIngredientsUseCase->__invoke();
        $server_fqdn = env('SERVER_FQDN');
        return view('arneon/laravel-pizzas::admin_pizzas', compact(['pizzas', 'ingredients', 'server_fqdn']));
    }
}
