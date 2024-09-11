<?php

namespace Arneon\LaravelGoogleAuth\Tests\Feature;

use Arneon\LaravelGoogleAuth\Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;
use Mockery;

class GoogleAuthTest extends TestCase
{
    public function test_redirect_to_google()
    {
        $response = $this->get('api/google-auth/redirect');
        $response->assertRedirect();
        $this->assertStringContainsString('accounts.google.com', $response->headers->get('Location'));
    }

    public function test_google_callback_creates_user()
    {
        $mockedUser = Mockery::mock('Laravel\Socialite\Contracts\User');
        $mockedUser->shouldReceive('getId')->andReturn('google-id');
        $mockedUser->shouldReceive('getName')->andReturn('Test User');
        $mockedUser->shouldReceive('getEmail')->andReturn('user@example.com');

        Socialite::shouldReceive('driver->stateless->user')->andReturn($mockedUser);

        $response = $this->get('api/google-auth/callback');

        $this->assertDatabaseHas('users', [
            'email' => 'user@example.com',
            'name' => 'Test User',
            'google_id' => 'google-id',
        ]);
    }

}
