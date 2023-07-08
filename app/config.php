<?php

declare(strict_types=1);

return [
    'db' => [
        'dbname' => 'routing-auth-boilerplate',
        'user' => 'root',
        'pass' => '',
        'host' => 'localhost',
        'port' => 3306,
        'charset' => 'utf8mb4',
    ],
    'session' => [
        'lifetime' => strval(60 * 2), // 2 minutes for testing you may want something like 7 days 60 * 60 * 24 * 7
    ]
];
