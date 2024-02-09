<?php

namespace Klobkovsky\App;

class DB
{
    /** @var \PDO */
    public $pdo;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        try {
            $this->pdo = new \PDO(
                "pgsql:host={$_ENV['POSTGRES_HOST']};dbname={$_ENV['POSTGRES_DATABASE']}",
                $_ENV['POSTGRES_USER'],
                $_ENV['POSTGRES_PASSWORD']
            );
        } catch (\PDOException $e) {
            throw new \Exception('Ошибка при подключении к базе данных: ' . $e->getMessage());
        }
    }
}
