<?php

namespace Arneon\LaravelGoogleAuth\Infrastructure\Requests;

use App\Http\Controllers\Controller;
use Arneon\LaravelGoogleAuth\Domain\Contracts\Requests\LoginRequest as RequestInterface;
use Illuminate\Http\Request;

class LoginRequest extends Controller implements RequestInterface
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
                'google_id' => 'required|string',
                'email' => 'required|email',
            ];

            $messages = [
                'google_id.required' => 'GoogleId is required',
                'google_id.string' => 'GoogleId should be string',
                'email.required' => 'Email is required',
                'email.email' => 'Should be Email format',
            ];

            return $this->validate($this->request, $rules, $messages);
        }catch(\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}
