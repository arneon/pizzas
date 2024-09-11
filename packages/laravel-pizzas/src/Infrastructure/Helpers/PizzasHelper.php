<?php

namespace Arneon\LaravelPizzas\Infrastructure\Helpers;

trait PizzasHelper
{
    public function setEntityValuesToModel($model, $entityArray)
    {
        foreach ($model->getFillable() as $field)
        {
            if(array_key_exists($field, $entityArray))
            {
                $model->{$field} = $entityArray[$field];
            }
        }
        return $model;
    }

    private function buildPizzaArray($pizzaModel, $notUsedIngredients=[]) : array
    {
        $price = 0.0;
        $incrementPercent = env('INCREMENT_PERCENT');
        $ingredients = [];

        foreach ($pizzaModel->ingredients as $ingredient) {
            if(!in_array($ingredient->id, $notUsedIngredients)) {
                $price += $ingredient->price;
                $ingredients[] = $ingredient->name;
            }
        }
        $total_price = number_format(($price + ($price * $incrementPercent / 100)), 2, '.', '');

        $redisPizza = [
            'id' => $pizzaModel->id,
            'name' => $pizzaModel->name,
            'image' => $pizzaModel->image,
            'description' => $pizzaModel->description,
            'price' => $total_price,
            'ingredients' => $ingredients,
        ];
        return $redisPizza;
    }
}
