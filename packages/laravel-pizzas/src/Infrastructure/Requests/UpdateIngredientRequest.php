<?php

namespace Arneon\LaravelPizzas\Infrastructure\Requests;

use App\Http\Controllers\Controller;
use Arneon\LaravelPizzas\Domain\Contracts\Requests\UpdateRequest as RequestInterface;
use Illuminate\Http\Request;

class UpdateIngredientRequest extends Controller implements RequestInterface
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
                'id' => 'required|integer|exists:ingredients,id',
                'name' => 'required|string|min:3|max:100|unique:ingredients,name,'.$this->request['id'],
                'price' => 'required|numeric|min:0.01',
            ];
            $messages = [
                'id.required' => 'id is required',
                'id.integer' => 'id is integer',
                'id.exists' => 'id is invalid',
                'name.required' => 'Name is required',
                'name.min' => 'Name must be at least 3 characters',
                'name.max' => 'Name may not be greater than 100 characters',
                'name.unique' => 'Name is already in use',
                'price.required' => 'Price is required',
                'price.numeric' => 'Price must be a valid number',
                'price.min' => 'Price must be at >= 0.01',
            ];
            return $this->validate($this->request, $rules, $messages);
        }catch(\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}
