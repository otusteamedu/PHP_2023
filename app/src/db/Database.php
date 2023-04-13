<?php
declare(strict_types=1);

namespace App\db;

use mysqli;

class Database {
    private $host;
    private $user;
    private $password;
    private $database;
    private $connection;

    public function __construct($host, $user, $password, $database) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;

        $this->connect();
    }

    public function __destruct() {
        $this->close();
    }

    private function connect() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function escapeString(string $value): string
    {
        return $this->connection->real_escape_string($value);
    }

    public function query($sql) {
        $result = $this->connection->query($sql);

        if ($result === false) {
            die("Error: " . $this->connection->error);
        }

        return $result;
    }

    public function fetchAll($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function close() {
        $this->connection->close();
    }
}
