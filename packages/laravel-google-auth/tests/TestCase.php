<?php

namespace Arneon\LaravelGoogleAuth\Tests;

use Tests\TestCase as BaseTestCase;
use Arneon\LaravelGoogleAuth\Infrastructure\Providers\PackageServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected string $token='';
    protected function getPackageProviders($app)
    {
        return [
            PackageServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh')->run();
    }
}
