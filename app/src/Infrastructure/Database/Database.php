<?php

declare(strict_types=1);

namespace App\Infrastructure\Database;

use PDO;

class Database
{
    private PDO $db;

    public function connect(): PDO
    {
        if (!isset($this->db)) {
            $this->db = new PDO(
                'mysql:host=' . getenv('DB_HOST') .
                ';port=3306;dbname=' . getenv('DB_NAME'),
                getenv('DB_USERNAME'),
                getenv('DB_PASSWORD')
            );
        }
        return $this->db;
    }
}
