<?php

namespace src\domain;

class DBStorageDTO
{
    private string $host;
    private int $port;
    private string $db;
    private string $user;
    private string $password;
    private string $dsn;

    /**
     * @param string $host
     * @param int $port
     * @param string $db
     * @param string $user
     * @param string $password
     */
    public function __construct(string $driver, string $host, int $port, string $db, string $user, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->db = $db;
        $this->user = $user;
        $this->password = $password;

        $this->dsn = $driver . ':host=' . $host . ';port=' . $port . ';dbname=' . $db;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getDb(): string
    {
        return $this->db;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDsn(): string
    {
        return $this->dsn;
    }
}
