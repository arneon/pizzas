<?php

namespace Arneon\LaravelPizzas\Tests\Feature;

use Arneon\LaravelPizzas\Tests\TestCase;

class IngredientsApiTest extends TestCase
{
    public function test_attempt_create_ingredient_bad_name_field()
    {
        $array = [
            'payload' => [
                ['name' => 123],
                ['name' => ''],
                ['name' => '12'],
                ['name' => '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890']
            ],
            'errorMessage' => [
                'The name field must be a string.',
                'The name field must be a string.',
                'The name field must be a string.',
            ],
        ];

        foreach ($array['payload'] as $ingredient1Payload) {
            $ingredient1Payload['price'] = 1.0;

            $response = $this->withToken("Bearer {$this->token}")
                ->postJson('/api/pizzas/ingredients', $ingredient1Payload);

            $response->assertStatus(400);
        }

    }

    public function test_create_ingredient_ok()
    {
        $ingredient1Payload = [
            'name' => 'Pomodoro',
            'price' => 0.85,
        ];

        $response = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient1Payload);

        $response->assertStatus(200);
    }

    public function test_delete_ingredient()
    {
        $ingredient1Payload = [
            'name' => 'Pomodoro',
            'price' => 3,
        ];

        $ingredient = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient1Payload);
        $ingredient->assertStatus(200);

        $ingredientDelete = $this->withToken("Bearer {$this->token}")
            ->deleteJson('/api/pizzas/ingredients/'.$ingredient['data']['id']);
        $ingredientDelete->assertStatus(200);
    }

}
