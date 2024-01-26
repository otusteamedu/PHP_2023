<?php
declare(strict_types=1);

namespace Daniel\Pattern;

use Dotenv\Dotenv;
use PDO;
class DatabaseConnection {
    private string $dsn;
    private string $user;
    private string $pass;
    private array $options;

    public function __construct() {

        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $this->dsn = "pgsql:host=$host;dbname=$dbname;options='--client_encoding=UTF8'";
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASSWORD'];
        $this->options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
    }

    public function connect(): PDO
    {
        try {
            return new PDO($this->dsn, $this->user, $this->pass, $this->options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}
