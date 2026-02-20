<?php

declare(strict_types=1);

return [
    'name' => 'IT Help Desk',
    'base_url' => '/',
    'timezone' => 'Asia/Bangkok',
    'database' => [
        'driver' => getenv('DB_DRIVER') ?: 'mysql',
        'host' => getenv('DB_HOST') ?: 'localhost:3306',
        'port' => getenv('DB_PORT') ?: '3306',
        'name' => getenv('DB_NAME') ?: 'help_desk',
        'username' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASS') ?: '',
        'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
    ],
];
