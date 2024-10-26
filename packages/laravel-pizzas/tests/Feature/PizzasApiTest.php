<?php

namespace Arneon\LaravelPizzas\Tests\Feature;

use Arneon\LaravelPizzas\Tests\TestCase;

class PizzasApiTest extends TestCase
{

    public function test_attempt_to_create_pizza_with_bad_name_field()
    {
        $ingredient1Payload = [
            'name' => 'Pomodoro',
            'price' => 3,
        ];
        $ingredient2Payload = [
            'name' => 'Mozzarela',
            'price' => 5,
        ];

        $ingredient1 = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient1Payload);
        $ingredient1->assertStatus(200);

        $ingredient2 = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient2Payload);
        $ingredient2->assertStatus(200);

        $array = [
            'payload' => [
                ['name' => 123],
                ['name' => ''],
                ['name' => '12'],
                ['name' => '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890']
            ],
            'errorMessage' => [
                'The name field must be a string.',
                'Pizza name is required',
                'Pizza name must be at least 3 characters',
                'Pizza name may not be greater than 100 characters',
            ],
        ];

        $index=0;
        foreach ($array['payload'] as $payload) {
            $payload['ingredients'] = [1,2];

            $response = $this->withToken("Bearer {$this->token}")
                ->postJson('/api/pizzas', $payload);

            $errorResponse = json_decode($response->getContent(), true);
            $response->assertStatus(400);
            $this->assertNotEmpty($errorResponse);
            $this->assertArrayHasKey('errors', $errorResponse);
            $this->assertEquals($array['errorMessage'][$index], $errorResponse['errors']['message']);
            $index++;
        }
    }

    public function test_attempt_to_create_pizza_without_ingredients()
    {
        $payload = [
            'name' => 'Test Pizza'
        ];

        $response = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas', $payload);
        $errorResponse = json_decode($response->getContent(), true);
        $response->assertStatus(400);
        $this->assertNotEmpty($errorResponse);
        $this->assertArrayHasKey('errors', $errorResponse);
        $this->assertEquals('Pizza ingredients are required', $errorResponse['errors']['message']);
    }

    public function test_attempt_to_create_pizza_with_only_one_ingredient()
    {
        $ingredient1Payload = [
            'name' => 'Pomodoro',
            'price' => 3,
        ];
        $ingredient1 = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient1Payload);
        $ingredient1->assertStatus(200);

        $payload = [
            'name' => 'Test Pizza',
            'ingredients' => [1],
        ];

        $response = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas', $payload);
        $errorResponse = json_decode($response->getContent(), true);
        $response->assertStatus(400);
        $this->assertNotEmpty($errorResponse);
        $this->assertArrayHasKey('errors', $errorResponse);
        $this->assertEquals('Pizza ingredients must be 2 at least', $errorResponse['errors']['message']);
    }

    public function test_attempt_to_create_pizza_with_ingredients_that_not_exists()
    {
        $ingredient1Payload = [
            'name' => 'Pomodoro',
            'price' => 3,
        ];
        $ingredient1 = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient1Payload);
        $ingredient1->assertStatus(200);

        $payload = [
            'name' => 'Test Pizza',
            'ingredients' => [1,2],
        ];

        $response = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas', $payload);
        $errorResponse = json_decode($response->getContent(), true);
        $response->assertStatus(400);
        $this->assertNotEmpty($errorResponse);
        $this->assertArrayHasKey('errors', $errorResponse);
        $this->assertEquals('The selected ingredients.1 is invalid.', $errorResponse['errors']['message']);
    }

    public function test_create_pizza_ok()
    {
        $ingredient1Payload = [
            'name' => 'Pomodoro',
            'price' => 3,
        ];
        $ingredient2Payload = [
            'name' => 'Mozzarela',
            'price' => 5,
        ];

        $ingredient1 = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient1Payload);
        $ingredient1->assertStatus(200);

        $ingredient2 = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient2Payload);
        $ingredient2->assertStatus(200);

        $pizzaArray = [
            'name' => 'Margarita',
            'image' => 'test-image.jpg',
            'ingredients' => [1,2],
        ];
        $pizza = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas', $pizzaArray);
        $pizza->assertStatus(200);

        $allPizzas = $this->withToken("Bearer {$this->token}")
            ->get('/api/pizzas');

        $this->assertSame("12.00", $allPizzas->json()['data'][0]['price']);
    }

    public function test_delete_pizza()
    {
        $ingredient1Payload = [
            'name' => 'Pomodoro',
            'price' => 3,
        ];
        $ingredient2Payload = [
            'name' => 'Mozzarela',
            'price' => 5,
        ];

        $ingredient1 = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient1Payload);
        $ingredient1->assertStatus(200);

        $ingredient2 = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient2Payload);
        $ingredient2->assertStatus(200);

        $pizzaArray = [
            'name' => 'Margarita',
            'image' => 'test-image.jpg',
            'ingredients' => [1,2]
        ];
        $pizza = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas', $pizzaArray);
        $pizza->assertStatus(200);

        $pizzaDelete = $this->withToken("Bearer {$this->token}")
            ->deleteJson('/api/pizzas/'.$pizza['data']['id']);
        $pizzaDelete->assertStatus(200);



    }
}
