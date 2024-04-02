<?php

declare(strict_types=1);

namespace AYamaliev\hw13\Application\Db;

final class Connection
{
    private static ?Connection $conn = null;

    protected function __construct()
    {
    }

    public function connect(): \PDO
    {
        $conStr = sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            'postgres',
            '5432',
            $_ENV['POSTGRES_DB'],
            $_ENV['POSTGRES_USER'],
            $_ENV['POSTGRES_PASSWORD'],
        );

        $pdo = new \PDO($conStr);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public static function get(): ?Connection
    {
        if (null === static::$conn) {
            static::$conn = new self();
        }

        return static::$conn;
    }
}
