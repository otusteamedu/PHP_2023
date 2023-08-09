<?php

declare(strict_types=1);

namespace DEsaulenko\Hw13\DB;

class Connector
{
    private static ?Connector $instance = null;
    private \PDO $PDO;

    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return \PDO
     */
    public function getPDO(): \PDO
    {
        return $this->PDO;
    }

    protected function __construct()
    {
        try {
            $user = getenv(Constants::DB_USERNAME);
            $password = getenv(Constants::DB_PASSWORD);
            $dsn = $this->getDSN();
            $this->PDO = new \PDO($dsn, $user, $password);
        } catch (\Exception $e) {
        }
    }

    protected function getDSN(): string
    {
        $host = getenv(Constants::DB_HOST);
        $host .= ':' . getenv(Constants::DB_PORT);
        $database = getenv(Constants::DB_NAME);
        switch (getenv(Constants::DB_TYPE)) {
            case Types::TYPE_MYSQL:
                return "mysql:host=$host;dbname=$database";
            default:
                throw new \Exception('Unknown type db');
        }
    }
}
