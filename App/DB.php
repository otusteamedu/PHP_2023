<?php

namespace App;

use PDO;

class DB
{
    private static self $instance;
    private PDO $pdo;
    public static function getInstance($host, $db, $user, $password): DB|static
    {
        return static::$instance ?? static::$instance = new static((function () use ($host, $db, $user, $password) {
            $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            return new PDO($dsn, $user, $password, $opt);
        })());
    }
    private function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}
