<?php declare(strict_types=1);

namespace Neunet\App\Database;

use PDO;

class Database
{
    public function connect(): PDO
    {
        return new PDO(
            getenv('DB_DSN'),
            getenv('DB_USER'),
            getenv('DB_PASSWORD'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
}
