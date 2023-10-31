<?php

namespace App;

class DatabaseQueryResult implements \Iterator
{
    private array $result;
    private int $position;

    public function __construct($query, $params)
    {
        $this->position = 0;
        $db = Db::getInstance();
        $this->result = $db->query($query, $params) ?? [];
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
        return isset($this->array[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
