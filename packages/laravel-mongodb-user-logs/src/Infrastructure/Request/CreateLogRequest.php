<?php

namespace Arneon\MongodbUserLogs\Infrastructure\Request;

use App\Http\Controllers\Controller;
use Arneon\MongodbUserLogs\Domain\Request\CreateLogRequest as RequestInterface;
use Illuminate\Http\Request;

class CreateLogRequest extends Controller implements RequestInterface
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
                'level' => 'required|string|min:3|max:30',
                "message" => "required|string|min:10",
            ];

            $messages = [
                'level.required' => 'Log level is required',
                'level.min' => 'Log level must be at least 3 characters',
                'level.max' => 'Log level may not be greater than 30 characters',
                'message.required' => 'Log message is required',
                'message.min' => 'Log message must be at least 10 characters',
            ];

            return $this->validate($this->request, $rules, $messages);
        }catch(\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}
