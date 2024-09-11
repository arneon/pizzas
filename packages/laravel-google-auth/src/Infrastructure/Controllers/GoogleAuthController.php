<?php

namespace Arneon\LaravelGoogleAuth\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Arneon\LaravelGoogleAuth\Application\UseCases\LoginUseCase as UseCase;
use Arneon\LaravelGoogleAuth\Infrastructure\Requests\LoginRequest;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController
{
    public function __construct(
        private readonly UseCase $useCase,
    )
    {
    }

    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback(Request $request)
    {
        try{
            $user = Socialite::driver('google')->stateless()->user();
            $request->merge([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'google_id' => $user->getId(),
            ]);
        }catch(\Exception $e)
        {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }

        try{
            $loginRequest = new LoginRequest($request);
            $loginRequest->__invoke();
        }catch (\Exception $e){
            return response()->json(['errors' => ['message' => $e->getMessage()]], 400);
        }

        try {
            return response()->json(['data' => $this->useCase->__invoke($request->all())]);
        }catch (\Exception $e)
        {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 500);
        }
    }
}
