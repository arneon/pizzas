<?php

namespace Arneon\LaravelPizzas\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    public function run()
    {
        DB::table('ingredients')->insert(
            [
                [
                    'name' => 'Pomodoro',
                    'price' => 0.85,
                ],
                [
                    'name' => 'Queso Mozzarela',
                    'price' => 2.3,
                ],
                [
                    'name' => 'Queso Parmesano',
                    'price' => 2.15,
                ],
                [
                    'name' => 'Albahaca',
                    'price' => 0.5,
                ],
                [
                    'name' => 'Aceitunas',
                    'price' => 1,
                ],
                [
                    'name' => 'Cebolla',
                    'price' => 0.6,
                ],
                [
                    'name' => 'Salami',
                    'price' => 1.5,
                ],
            ]
        );
    }

}
