<?php

namespace Arneon\LaravelPizzas\Tests\Feature;

use Arneon\LaravelPizzas\Tests\TestCase;

class PizzasApiTest extends TestCase
{

    public function test_create_ingredient()
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

    public function test_create_pizza()
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
