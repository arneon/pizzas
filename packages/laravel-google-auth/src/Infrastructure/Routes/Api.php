<?php

namespace Arneon\LaravelGoogleAuth\Infrastructure\Routes;

use Illuminate\Support\Facades\Route;
use Arneon\LaravelGoogleAuth\Infrastructure\Controllers\GoogleAuthController as Controller;

Route::group(['prefix' => 'api/google-auth'], function () {

    Route::get('/redirect', [Controller::class, 'redirect']);
    Route::get('/callback', [Controller::class, 'callback']);
});
