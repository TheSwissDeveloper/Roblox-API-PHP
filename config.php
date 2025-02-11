<?php
return [
    'security' => [
        'allowed_games' => ['12345', '67890'],
        'rate_limit' => 60,
        'request_timeout' => 30,
        'cache_time' => 60,
        'max_retries' => 3,
        'ip_whitelist' => ['127.0.0.1']
    ],
    
    'database' => [
        'host' => 'localhost',
        'name' => 'api_db',
        'user' => 'user',
        'pass' => 'password'
    ],
    
    'logging' => [
        'enabled' => true,
        'path' => __DIR__ . '/logs/api.log',
        'level' => 'debug'
    ],
    
    'cache' => [
        'driver' => 'file',
        'path' => __DIR__ . '/cache'
    ],
    
    'hashing' => [
        'prefix' => 'gKnoW78niy5BDGx',  // Eigener Prefix
        'suffix' => '32d6tYQPaZPATHE',  // Eigener Suffix
        'seed' => 5381,                 // Basis-Seed
        'prime' => 31,                  // Prime-Nummer
        'salt' => 'nZcDmPqRtUvWxYz',    // Salt für zusätzliche Sicherheit
        'custom_chars' => 'abcdefghijklmnopqrstuvwxyz', // Erlaubte Zeichen
        'output_length' => 32           // Gewünschte Hash-Länge
    ]
];
