<?php

namespace Arneon\LaravelPizzas\Tests\Feature;

use Arneon\LaravelPizzas\Tests\TestCase;

class IngredientsApiTest extends TestCase
{
    public function test_attempt_to_create_ingredient_with_bad_name_field()
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
                'Ingredient name is required',
                'Ingredient name must be at least 3 characters',
                'Ingredient name may not be greater than 100 characters',
            ],
        ];

        $index=0;
        foreach ($array['payload'] as $ingredient1Payload) {
            $ingredient1Payload['price'] = 1.0;

            $response = $this->withToken("Bearer {$this->token}")
                ->postJson('/api/pizzas/ingredients', $ingredient1Payload);

            $errorResponse = json_decode($response->getContent(), true);
            $response->assertStatus(400);
            $this->assertNotEmpty($errorResponse);
            $this->assertArrayHasKey('errors', $errorResponse);
            $this->assertEquals($array['errorMessage'][$index], $errorResponse['errors']['message']);
            $index++;
        }
    }

    public function test_attempt_to_create_ingredient_with_bad_price_field()
    {
        $array = [
            'payload' => [
                ['price' => ''],
                ['price' => 'dasda'],
                ['price' => -1],
            ],
            'errorMessage' => [
                'Ingredient price is required',
                'Ingredient price should be a numeric value',
                'Ingredient price should be >= 0.01',
            ],
        ];

        $index=0;
        foreach ($array['payload'] as $ingredient1Payload) {
            $ingredient1Payload['name'] = 'Test ingredient name';

            $response = $this->withToken("Bearer {$this->token}")
                ->postJson('/api/pizzas/ingredients', $ingredient1Payload);

            $errorResponse = json_decode($response->getContent(), true);
            $response->assertStatus(400);
            $this->assertNotEmpty($errorResponse);
            $this->assertArrayHasKey('errors', $errorResponse);
            $this->assertEquals($array['errorMessage'][$index], $errorResponse['errors']['message']);
            $index++;
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

    public function test_attempt_to_delete_ingredient_that_does_not_exist()
    {
        $response = $this->withToken("Bearer {$this->token}")
            ->deleteJson('/api/pizzas/ingredients/999');
        $errorResponse = json_decode($response->getContent(), true);
        $response->assertStatus(400);
        $this->assertNotEmpty($errorResponse);
        $this->assertArrayHasKey('errors', $errorResponse);
        $this->assertEquals('This ingredient does not exist', $errorResponse['errors']['message']);
    }

    public function test_delete_ingredient_ok()
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

    public function test_attempt_to_update_ingredient_with_bad_name_field()
    {
        $ingredient1Payload = [
            'name' => 'Pomodoro',
            'price' => 0.85,
        ];

        $createResponse = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient1Payload);
        $rowCreated = json_decode($createResponse->getContent(), true);
        $newId = $rowCreated['data']['id'];

        $array = [
            'payload' => [
                ['name' => 123],
                ['name' => ''],
                ['name' => '12'],
                ['name' => '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890']
            ],
            'errorMessage' => [
                'The name field must be a string.',
                'Name is required',
                'Name must be at least 3 characters',
                'Name may not be greater than 100 characters',
            ],
        ];

        $index=0;
        foreach ($array['payload'] as $ingredient1Payload) {
            $ingredient1Payload['price'] = 1.0;

            $response = $this->withToken("Bearer {$this->token}")
                ->putJson('/api/pizzas/ingredients/'.$newId, $ingredient1Payload);

            $errorResponse = json_decode($response->getContent(), true);
            $response->assertStatus(400);
            $this->assertNotEmpty($errorResponse);
            $this->assertArrayHasKey('errors', $errorResponse);
            $this->assertEquals($array['errorMessage'][$index], $errorResponse['errors']['message']);
            $index++;
        }
    }

    public function test_attempt_to_update_ingredient_with_bad_price_field()
    {
        $ingredient1Payload = [
            'name' => 'Pomodoro',
            'price' => 0.85,
        ];

        $createResponse = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient1Payload);
        $rowCreated = json_decode($createResponse->getContent(), true);
        $newId = $rowCreated['data']['id'];

        $array = [
            'payload' => [
                ['price' => ''],
                ['price' => 'dasda'],
                ['price' => -1],
            ],
            'errorMessage' => [
                'Price is required',
                'Price must be a valid number',
                'Price must be at >= 0.01',
            ],
        ];

        $index=0;
        foreach ($array['payload'] as $ingredient1Payload) {
            $ingredient1Payload['name'] = 'Test ingredient name';

            $response = $this->withToken("Bearer {$this->token}")
                ->putJson('/api/pizzas/ingredients/'.$newId, $ingredient1Payload);

            $errorResponse = json_decode($response->getContent(), true);
            $response->assertStatus(400);
            $this->assertNotEmpty($errorResponse);
            $this->assertArrayHasKey('errors', $errorResponse);
            $this->assertEquals($array['errorMessage'][$index], $errorResponse['errors']['message']);
            $index++;
        }
    }

    public function test_update_ingredient_ok()
    {
        $ingredient1Payload = [
            'name' => 'Pomodoro',
            'price' => 0.85,
        ];

        $createResponse = $this->withToken("Bearer {$this->token}")
            ->postJson('/api/pizzas/ingredients', $ingredient1Payload);
        $rowCreated = json_decode($createResponse->getContent(), true);
        $newId = $rowCreated['data']['id'];

        $payload = [
                'name' => 'Test ingredient name',
                'price' => 5,
        ];

        $response = $this->withToken("Bearer {$this->token}")
            ->putJson('/api/pizzas/ingredients/'.$newId, $payload);

        $messageResponse = json_decode($response->getContent(), true);
        $response->assertStatus(200);
        $this->assertNotEmpty($messageResponse);
        $this->assertArrayHasKey('data', $messageResponse);
        $this->assertEquals('Test ingredient name', $messageResponse['data']['name']);
    }

}
