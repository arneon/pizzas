<?php

namespace Arneon\LaravelPizzas\Infrastructure\Requests;

use App\Http\Controllers\Controller;
use Arneon\LaravelPizzas\Domain\Contracts\Requests\CreateRequest as RequestInterface;
use Illuminate\Http\Request;

class CreateIngredientRequest extends Controller implements RequestInterface
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
                'name' => 'required|string|min:3|max:100|unique:ingredients,name',
                "price" => "required|numeric|min:0.01",
            ];

            $messages = [
                'name.required' => 'Ingredient name is required',
                'name.unique' => 'Ingredient name already exists',
                'name.min' => 'Ingredient name must be at least 3 characters',
                'name.max' => 'Ingredient name may not be greater than 100 characters',
                'price.required' => 'Ingredient price is required',
                'price.numeric' => 'Ingredient price should be a numeric value',
                'price.min' => 'Ingredient price should be >= 0.01',
            ];

            return $this->validate($this->request, $rules, $messages);
        }catch(\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}
