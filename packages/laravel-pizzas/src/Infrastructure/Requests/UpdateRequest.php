<?php

namespace Arneon\LaravelPizzas\Infrastructure\Requests;

use App\Http\Controllers\Controller;
use Arneon\LaravelPizzas\Domain\Contracts\Requests\UpdateRequest as RequestInterface;
use Illuminate\Http\Request;

class UpdateRequest extends Controller implements RequestInterface
{
    private Request $request;
    public function __construct(int $id, Request $request)
    {
        $request->merge(['id' => $id ]);
        $this->request = $request;
    }

    public function __invoke(): array|\Exception
    {
        try {
            $rules = [
                'id' => 'required|integer|exists:pizzas,id',
                'name' => 'required|string|min:3|max:100|unique:pizzas,name,'.$this->request['id'],
                "ingredients" => "required|array|min:2",
                'ingredients.*' => 'required|integer|exists:ingredients,id',
            ];
            $messages = [
                'id.required' => 'PizzaId is required',
                'id.integer' => 'PizzaId should be integer',
                'id.exists' => 'PizzaId does not exists',
                'name.required' => 'Name is required',
                'name.min' => 'Name must be at least 3 characters',
                'name.max' => 'Name may not be greater than 100 characters',
                'name.unique' => 'Pizza already exists with this name',
                'ingredients.required' => 'Ingredients is required',
                'ingredients.array' => 'Ingredients must be array',
                'ingredients.min' => 'Ingredients must be 2 at least',
                'ingredients.*.id.required' => 'Ingredients is required',
                'ingredients.*.id.integer' => 'Ingredients must be integer',
                'ingredients.*.id.exists' => 'Ingredients does not exist',
            ];
            return $this->validate($this->request, $rules, $messages);
        }catch(\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}
