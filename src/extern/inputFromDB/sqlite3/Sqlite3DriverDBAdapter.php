<?php

namespace src\extern\inputFromDB\sqlite3;

class Sqlite3DriverDBAdapter implements DBAdapterInterface
{
    private string $source;
    private string $query;
    private array $data;

    private \SQLite3 $dbConn;

    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    public function setSource(string $source): static
    {
        $this->source = $source;
        $this->dbConn = new \SQLite3($this->source);
        return $this;
    }

    public function setQuery(string $query): static
    {
        $this->query = $query;
        return $this;
    }

    public function fetch(): static
    {
        $results = $this->dbConn->query($this->query);
        $data = [];
        while ($res = $results->fetchArray(1)) {
            $data[] = $res;
        }

        $this->data = $data;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
