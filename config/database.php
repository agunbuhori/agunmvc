<?php

return [
    'provider' => env('DATABASE_PROVIDER', 'mysql'),

    'mysql' => [
        'host' => env('DATABASE_HOST', 'localhost'),
        'dbname' => env('DATABASE_NAME', 'something'),
        'username' => env('DATABASE_USERNAME', 'root'),
        'password' => env('DATABASE_PASSWORD', 'forget'),
    ]
];