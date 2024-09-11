<?php

namespace Arneon\LaravelPizzas\Infrastructure\Persistence\Redis;

use Arneon\LaravelPizzas\Domain\Repositories\Repository as RepositoryInterface;
use Illuminate\Support\Facades\Redis;

class RedisRepository implements RepositoryInterface
{
    private const REDIS_PIZZAS_KEY = 'pizzas';

    public function findAllPizzas()
    {
        $pizzas = Redis::get(self::REDIS_PIZZAS_KEY);
        if ($pizzas) {
            $dataArray = json_decode($pizzas, true);
            return $dataArray;
        }

        return [];
    }

    public function findPizzaById(int $id)
    {

    }

    public function createPizza(array $data)
    {
        $pizzas = Redis::get(self::REDIS_PIZZAS_KEY);
        $pizzasArray = ($pizzas) ? json_decode($pizzas, true) : [];

        if (!empty($pizzasArray)) {
            $founded = false;
            foreach ($pizzasArray as &$pizza) {
                if ($pizza['id'] == $data['id']) {
                    $founded = true;
                    $pizza = $data;
                }
            }
            if(!$founded) {
                $pizzasArray[] = $data;
            }
        }
        else
        {
            $pizzasArray[] = $data;
        }

        Redis::set(self::REDIS_PIZZAS_KEY, json_encode($pizzasArray));
    }

    public function updatePizza($id, array $data)
    {
        $pizzas = Redis::get(self::REDIS_PIZZAS_KEY);
        $pizzasArray = ($pizzas) ? json_decode($pizzas, true) : [];

        if (!empty($pizzasArray)) {
            $founded = false;
            foreach ($pizzasArray as &$pizza) {
                if ($pizza['id'] == $id) {
                    $founded=true;
                    $pizza = $data;
                }
            }

            if(!$founded)
            {
                $pizzasArray[] = $data;
            }
        }
        else
        {
            $pizzasArray[] = $data;
        }

        Redis::set(self::REDIS_PIZZAS_KEY, json_encode($pizzasArray));
    }

    public function deletePizza($id)
    {
        $pizzas = Redis::get(self::REDIS_PIZZAS_KEY);
        $pizzasArray = ($pizzas) ? json_decode($pizzas, true) : [];
        $filteredPizzas = [];

        if (!empty($pizzasArray)) {
            foreach ($pizzasArray as &$pizza)
            {
                if($pizza['id'] == $id)
                {
                    $filteredPizzas = array_values(array_filter($pizzasArray, function ($pizza) use ($id) {
                        return $pizza['id'] != $id;
                }));
                }
            }
        }

        Redis::set(self::REDIS_PIZZAS_KEY, json_encode($filteredPizzas));
    }

    public function replacePizzas(array $data)
    {
        return is_array($data) ? Redis::set(self::REDIS_PIZZAS_KEY, json_encode($data)) : false;
    }

    public function findAllIngredients()
    {
        // NOTE: It is not necessary to Implement the method in this repository.
    }

    public function findPizzaIngredients($pizzaId)
    {
        // NOTE: It is not necessary to Implement the method in this repository.
    }

    public function createIngredient(array $data)
    {
        // NOTE: It is not necessary to Implement the method in this repository.
    }

    public function updateIngredient($id, array $data)
    {
        // NOTE: It is not necessary to Implement the method in this repository.
    }

    public function deleteIngredient($id)
    {
        // NOTE: It is not necessary to Implement the method in this repository.
    }
}

