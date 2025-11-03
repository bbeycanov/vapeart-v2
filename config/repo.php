<?php

return [
    'cache' => [
        'enabled' => env('REPO_CACHE_ENABLED', true),
        'ttl'     => env('REPO_CACHE_TTL', 3600),
        'store'   => env('REPO_CACHE_STORE', env('CACHE_STORE', env('CACHE_DRIVER', 'redis'))),
        'prefix'  => env('REPO_CACHE_PREFIX', 'repo:'),
    ],
];
