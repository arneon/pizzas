<?php

namespace Arneon\LaravelGoogleAuth\Infrastructure\Persistence\Eloquent;

use Arneon\LaravelGoogleAuth\Domain\Repositories\Repository as RepositoryInterface;
use Arneon\LaravelGoogleAuth\Infrastructure\Models\User as Model;

class EloquentRepository implements RepositoryInterface
{

    public function login(array $data)
    {
        $user = new Model();
        $user = $user->where('email', $data['email'])->firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'password' => null,
                'google_id' => $data['google_id'],
            ]
        );

        if(empty($user->getAttribute('google_id')))
        {
            $user->setAttribute('google_id', $data['google_id']);
        }
        $user->save();

        return $user->toArray();
    }
}

