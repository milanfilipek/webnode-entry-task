<?php

declare(strict_types=1);

namespace App\Factory\Database;

use App\Infrastructure\Database\Database;

class DatabaseFactory
{
    public static function create(): Database
    {
        $host = $_ENV['DB_HOST'];
        $db = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASSWORD'];

        $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";

        return new Database($dsn, $user, $pass);
    }
}
