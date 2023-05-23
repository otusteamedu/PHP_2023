<?php

namespace Yakovgulyuta\Hw13\Core\Database\ActiveRecord;

use PDO;
use Yakovgulyuta\Hw13\Config\InitConfig;

class Db
{
    public PDO $pdo;

    public function __construct()
    {
        $config = InitConfig::init();
        $database = $config->get('database');
        $this->pdo = new PDO(
            $database['driver'] . ':host=' . $database['host'] . ';dbname=' . $database['database'],
            $database['username'],
            $database['password'],
        );
    }

    public function execute(string $sql, array $data): bool
    {
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($data);
    }

    public function query(string $sql, array $data, ?string $className = null): false|array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        return $stmt->fetchAll(PDO::FETCH_CLASS, $className);
    }

    public function queryLazy(string $sql, array $data, ?string $className = null): false|array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        return $stmt->fetchAll(PDO::FETCH_CLASS, $className);
    }

    public function lastId(): int
    {
        return (int)$this->pdo->lastInsertId();
    }
}
