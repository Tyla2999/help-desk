<?php

declare(strict_types=1);

namespace App\Services;

use PDO;

class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $config = require base_path('config/app.php');
        $database = $config['database'] ?? [];

        $driver = (string) ($database['driver'] ?? 'mysql');
        $host = (string) ($database['host'] ?? '127.0.0.1');
        $port = (string) ($database['port'] ?? '3306');
        $dbname = (string) ($database['name'] ?? 'help_desk');
        $charset = (string) ($database['charset'] ?? 'utf8mb4');
        $username = (string) ($database['username'] ?? 'root');
        $password = (string) ($database['password'] ?? '');

        $dsn = sprintf('%s:host=%s;port=%s;dbname=%s;charset=%s', $driver, $host, $port, $dbname, $charset);

        self::$connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return self::$connection;
    }
}
