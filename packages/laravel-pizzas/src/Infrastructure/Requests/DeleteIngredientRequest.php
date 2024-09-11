<?php

namespace Arneon\LaravelPizzas\Infrastructure\Requests;

use App\Http\Controllers\Controller;
use Arneon\LaravelPizzas\Domain\Contracts\Requests\DeleteRequest as RequestInterface;
use Illuminate\Http\Request;

class DeleteIngredientRequest extends Controller implements RequestInterface
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
                'id' => 'required|integer|exists:ingredients,id|unique:pizza_ingredients,ingredient_id',
            ];
            $messages = [
                'id.required' => 'Ingredient ID is required.',
                'id.integer' => 'Ingredient id must be an integer',
                'id.exists' => 'This ingredient does not exist',
                'id.unique' => 'This ingredient is in at least one pizza. It cannot be deleted',
            ];
            return $this->validate($this->request, $rules, $messages);
        }catch(\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}
