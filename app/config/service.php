<?php

return new \Phalcon\Config([
    'messagecenter'=> [
        'adapter' => env('MC_ADAPTER', 'rabbit'),
        'host' => env('MC_HOST', 'localhost'),
        'port' => env('MC_PORT', '5672'),
        'username' => env('MC_USER', 'guest'),
        'password' => env('MC_PASSWORD', 'guest'),
        'vhost' => env('MC_VHOST', '/'),
        'type' => 'lazy',
        'exchangeType' => 'topic',
        'class' => 'MessageCenter',
        'exchangePrefix' => env('MC_EXCHANGE_PREFIX'),
        'queuePrefix' => env('MC_QUEUE_PREFIX')
        //'connection' => 'database_local'
    ]
]);