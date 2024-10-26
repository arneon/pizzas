<?php

return [
    'connection' => [
        'driver' => 'mongodb',
        'connection' => 'mongodb',
        'database' => env('MONGODB_NAME', 'laravel-mongodb-user-logs'),
//        'uri' => env('MONGODB_URI'),
    ],

    'table' => 'user_logs',

    'fillable' => [
        'level',
        'message',
        'context',
    ],

];
