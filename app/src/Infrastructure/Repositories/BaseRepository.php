<?php

declare(strict_types=1);

namespace Yevgen87\App\Infrastructure\Repositories;

use PDO;
class BaseRepository
{
    protected PDO $pdo;

    public function __construct()
    {
        $config = require(__DIR__ . '../../config/db.php');

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
}
