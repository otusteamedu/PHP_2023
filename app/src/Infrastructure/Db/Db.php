<?php

namespace App\Infrastructure\Db;

use Exception;
use PDO;

class Db
{
    private static ?PDO $pdo = null;

    /**
     * @throws Exception
     */
    public static function getPdo(): PDO
    {
        if (is_null(self::$pdo)) {
            try {
                self::$pdo = new PDO(
                    "mysql:host={$_ENV['MYSQL_HOST']};dbname={$_ENV['MYSQL_DATABASE']}",
                    $_ENV['MYSQL_USER'],
                    $_ENV['MYSQL_PASSWORD']
                );
                self::$pdo->exec('SET NAMES UTF8');
            } catch (\PDOException $e) {
                throw new Exception('Ошибка при подключении к базе данных: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
