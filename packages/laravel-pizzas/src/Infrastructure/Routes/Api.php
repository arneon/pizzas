<?php

namespace Arneon\LaravelPizzas\Infrastructure\Routes;

use Illuminate\Support\Facades\Route;
use Arneon\LaravelPizzas\Infrastructure\Controllers\PizzaController as Controller;

Route::group([
    'prefix' => 'api/pizzas',
    'middleware' => [
        'api',
        'middleware' => 'auth:sanctum',
    ],
], function () {
    Route::get('', [Controller::class, 'listPizzas']);
});

Route::group([
    'prefix' => 'api/pizzas',
    'middleware' => [
        'web',
        'middleware' => 'auth:sanctum',
    ],
], function () {
    Route::get('manage', [Controller::class, 'adminPizzas']);
    Route::post('', [Controller::class, 'createPizza']);
    Route::get('find-by-id/{id}', [Controller::class, 'findPizza']);
    Route::put('{id}', [Controller::class, 'updatePizza']);
    Route::delete('{id}', [Controller::class, 'deletePizza']);

    Route::get('ingredients', [Controller::class, 'listIngredients']);
    Route::post('ingredients', [Controller::class, 'createIngredient']);
    Route::put('ingredients/{id}', [Controller::class, 'updateIngredient']);
    Route::delete('ingredients/{id}', [Controller::class, 'deleteIngredient']);
});


Route::group([
    'middleware' => ['web'],
    'prefix' => 'web/pizzas',
], function () {

    Route::get('menu', [Controller::class, 'customerPizzas']);
});
