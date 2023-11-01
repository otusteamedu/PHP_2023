<?php

namespace App;

class DatabaseQueryResult implements \Iterator
{
    protected ?array $result;
    protected int $position;
    protected Db $db;

    public function __construct($query, $params)
    {
        $this->position = 0;
        $this->db = Db::getInstance();
        $this->result = $this->db->query($query, $params);
    }

    public function current(): mixed
    {
        return $this->result[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->result[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
