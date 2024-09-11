<?php

namespace Arneon\LaravelPizzas\Infrastructure\Requests;

use App\Http\Controllers\Controller;
use Arneon\LaravelPizzas\Domain\Contracts\Requests\CreateRequest as RequestInterface;
use Illuminate\Http\Request;

class CreateRequest extends Controller implements RequestInterface
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __invoke(): array|\Exception
    {
        try {
            $rules = [
                'name' => 'required|string|min:3|max:100|unique:pizzas,name',
                "ingredients" => "required|array|min:2",
                'ingredients.*' => 'required|integer|exists:ingredients,id',
            ];

            $messages = [
                'name.required' => 'Pizza name is required',
                'name.unique' => 'Pizza name already exists',
                'name.min' => 'Pizza name must be at least 3 characters',
                'name.max' => 'Pizza name may not be greater than 100 characters',
                'ingredients.required' => 'Pizza ingredients are required',
                'ingredients.array' => 'Pizza ingredients must be array',
                'ingredients.min' => 'Pizza ingredients must be 2 at least',
                'ingredients.*.id.required' => 'Pizza ingredients are required',
                'ingredients.*.id.integer' => 'Pizza ingredients must be integer',
                'ingredients.*.id.exists' => 'Pizza ingredient(s) not exists',
            ];

            return $this->validate($this->request, $rules, $messages);
        }catch(\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}
