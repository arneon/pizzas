<?php

namespace Arneon\LaravelPizzas\Domain\Repositories;

interface Repository
{
    public function findAllPizzas();
    public function findPizzaById(int $id);
    public function createPizza(array $data);
    public function updatePizza($id, array $data);
    public function deletePizza($id);
    public function findAllIngredients();
    public function findPizzaIngredients($pizzaId);
    public function createIngredient(array $data);
    public function updateIngredient($id, array $data);
    public function deleteIngredient($id);
}

