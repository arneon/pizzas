<?php

namespace Arneon\MongodbUserLogs\Infrastructure\Routes;

use Illuminate\Support\Facades\Route;
use Arneon\MongodbUserLogs\Infrastructure\Controller\MongodbLogController as Controller;

Route::group([
    'prefix' => 'api/mongodb-user-logs',
    'middleware' => [
        'api',
//        'middleware' => 'auth:sanctum',
    ],
], function () {
    Route::get('', [Controller::class, 'findAll']);
    Route::post('', [Controller::class, 'create']);
});
