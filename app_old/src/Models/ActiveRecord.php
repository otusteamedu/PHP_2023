<?php

declare(strict_types=1);

namespace Yevgen87\App\Models;

use PDO;

abstract class ActiveRecord implements ActiveRecordInterface
{
    /**
     * @var PDO
     */
    protected PDO $pdo;

    public function __construct()
    {
        $config = require(__DIR__ . '/../config/db.php');

        $config = $config[$config['driver']];

        $dbname = $config['database'] ?? null;

        $username = $config['username'] ?? null;

        $password = $config['username'] ?? null;

        $host = $config['host'] ?? null;

        $port = $config['port'] ?? null;

        $dsn = "pgsql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname;

        $pdo = new PDO($dsn, $username, $password, []);

        $this->pdo = $pdo;
    }

    abstract public function fetchAll();

    abstract public function fetchById(int $id);

    abstract public function insert(array $data);

    abstract public function update(int $id, array $data);

    abstract public function delete(int $id);
}
