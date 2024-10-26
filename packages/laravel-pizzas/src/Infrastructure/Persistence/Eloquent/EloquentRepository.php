<?php

namespace Arneon\LaravelPizzas\Infrastructure\Persistence\Eloquent;

use Arneon\LaravelPizzas\Domain\Repositories\Repository as RepositoryInterface;
use Arneon\LaravelPizzas\Infrastructure\Models\Ingredient as ModelIngredient;
use Arneon\LaravelPizzas\Infrastructure\Models\Pizza as Model;
use Illuminate\Support\Facades\DB;


class EloquentRepository implements RepositoryInterface
{

    public function findByField(mixed $fieldValue, string $field = 'id')
    {
        try {
            $user = new Model();
            $fields = array_merge($user->getFillable(), ['id']);
            if(!in_array($field, $fields))
            {
                throw new \Exception('Field does not exist');
            }

            $user = $user->where($field, $fieldValue)->first();
            return $user ? $user->toArray() : [];
        }
        catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function findAllPizzas()
    {
        return Model::all();
    }
    public function findPizzaById(int $id)
    {
        $model = Model::where('id', $id)->first();

        if($model)
        {
            $ingredients = $model->ingredients;
            $model = $model->toArray();
            $model['ingredients'] = $ingredients;
            return $model;
        }
        else{
            return [];
        }
    }

    public function createPizza(array $data)
    {
        DB::beginTransaction();
        try {
            $model = new Model();
            $model->fill($data);
            $model->save();
            foreach ($data['ingredients'] as $ingredient) {
                $model->ingredients()->attach($ingredient);
            }
            DB::commit();
            return $model->toArray();
        }catch (\Exception $e){
                DB::rollBack();
                throw new \Exception($e->getMessage());
        }
    }

    public function updatePizza($id, array $data)
    {
        $model = Model::where('id', $id)->first();
        if($model)
        {
            DB::beginTransaction();
            try {

                $model->ingredients()->detach();

                $model->fill($data);
                $model->save();
                foreach ($data['ingredients'] as $ingredient) {
                    $model->ingredients()->attach($ingredient);
                }
                DB::commit();
                return $model->toArray();
            }catch (\Exception $e){
                DB::rollBack();
                throw new \Exception($e->getMessage());
            }
        }
        else
        {
            throw new \Exception('Pizza not found', 404);
        }
    }

    public function deletePizza($id)
    {
        $model = Model::where('id', $id)->first();
        if($model)
        {
            $model->delete();
            return ['message' => 'Pizza deleted successfully.'];
        }
        else
        {
            throw new \Exception('Pizza not found', 404);
        }
    }

    public function findAllIngredients()
    {
        return ModelIngredient::all()->toArray();
    }

    public function findPizzaIngredients($pizzaId)
    {
        // TODO: Implement findPizzaIngredients() method.
    }

    public function createIngredient(array $data)
    {
        $model = new ModelIngredient();
        $model->fill($data);
        $model->save();
        return $model->toArray();
    }

    public function findPizzasByIngredient(int $ingredientId)
    {
        $pizzas = Model::whereHas('ingredients', function($query) use ($ingredientId) {
            $query->where('ingredient_id', $ingredientId);
        })->get();

        return ($pizzas) ?? [];
    }


    public function updateIngredient($id, array $data)
    {
        $ingredientModel = ModelIngredient::where('id', $id)->first();
        if($ingredientModel)
        {
            $ingredientModel->fill($data);
            $ingredientModel->save();
            return $ingredientModel->toArray();
        }
        else
        {
            throw new \Exception('User not found', 404);
        }
    }

    public function deleteIngredient($id)
    {
        $model = ModelIngredient::where('id', $id)->first();
        if($model)
        {
            $model->delete();
            return ['id' => $id];
        }
        else
        {
            throw new \Exception('Ingredient not found', 404);
        }
    }
}

