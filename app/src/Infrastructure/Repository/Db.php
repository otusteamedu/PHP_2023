<?php

namespace App\Infrastructure\Repository;

use Exception;
use PDO;

class Db
{
    /** @var Db */
    private static $instance;

    /** @var PDO */
    private $pdo;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host={$_ENV['MYSQL_HOST']};dbname={$_ENV['MYSQL_DATABASE']}",
                $_ENV['MYSQL_USER'],
                $_ENV['MYSQL_PASSWORD']
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new Exception('Ошибка при подключении к базе данных: ' . $e->getMessage());
        }
    }

    public function query(string $sql, array $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}
