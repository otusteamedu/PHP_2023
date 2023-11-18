<?php

declare(strict_types=1);

namespace src\infrastructure\extern\inputFromDB\sqlite3;

error_reporting(E_ERROR | E_PARSE);

use SQLite3;

class Sqlite3DriverDBAdapter implements DBAdapterInterface
{
    private string $query;
    private array $data;

    private SQLite3 $dbConn;

    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    public function setSource(string $source): Sqlite3DriverDBAdapter
    {
        $this->dbConn = new SQLite3($source);
        return $this;
    }

    public function setQuery(string $query): Sqlite3DriverDBAdapter
    {
        $this->query = $query;
        return $this;
    }

    public function fetch(): Sqlite3DriverDBAdapter
    {
        $results = $this->dbConn->query($this->query);
        $data = [];
        while ($res = $results->fetchArray(1)) {
            $data[] = $res;
        }

        $this->data = $data;

        return $this;
    }

    public function execute(): bool
    {
        $stmt = $this->dbConn->prepare($this->query);

        return $stmt->execute() !== false;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
