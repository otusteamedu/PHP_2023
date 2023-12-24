<?php

namespace Klobkovsky\App;

class DB
{
    /** @var PDO */
    public $pdo;

    /**
     * @throws Exception
     */
    function __construct()
    {
        try {
            $this->pdo = new \PDO(
                "mysql:host={$_ENV['MYSQL_HOST']};dbname={$_ENV['MYSQL_DATABASE']}",
                $_ENV['MYSQL_USER'],
                $_ENV['MYSQL_PASSWORD']
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new Exception('Ошибка при подключении к базе данных: ' . $e->getMessage());
        }
    }
}
