<?php
/*return new \Phalcon\Config([
    'database' => [
        'adapter' => 'pdo\PostgreSQL',
        'host' => env('APP_DB_HOST'),
        'username' => env('APP_DB_USER'),
        'password' => env('APP_DB_PASSWORD'),
        'dbname' => env('APP_DB_DATABASE'),
        'useAnnotations' => false,
        'useCache' => false
    ]
]);*/

return new \Phalcon\Config([
    'database' => [
        'adapter' => env('APP_DB_ADAPTER'),
        'host' => env('APP_DB_HOST'),
        'username' => env('APP_DB_USER'),
        'port' => env('APP_DB_PORT'),
        'password' => env('APP_DB_PASSWORD'),
        'dbname' => env('APP_DB_DATABASE'),
        'useAnnotations' => false,
        'useCache' => false
    ]
]);