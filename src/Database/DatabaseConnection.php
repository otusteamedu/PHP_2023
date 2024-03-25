<?php

namespace Rabbit\Daniel\Database;

use PDO;
use PDOException;

class DatabaseConnection
{
    private $connection;

    private $dsn;

    private $username;

    private $password;

    public function __construct(string $dsn, string $username, string $password)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect(): void
    {
        if ($this->connection === null) {
            try {
                $this->connection = new PDO($this->dsn, $this->username, $this->password);

                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
    }
}