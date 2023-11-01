<?php

namespace App;

class DatabaseQueryResultProxy extends DatabaseQueryResult
{
    protected ?array $result = null;
    private string $query;
    private array $params;

    public function __construct($query, $params)
    {
        $this->position = 0;
        $this->db = Db::getInstance();
        $this->query = $query;
        $this->params = $params;
    }

    public function rewind(): void
    {
        if (is_null($this->result)) $this->result = $this->db->query($this->query, $this->params);
        parent::rewind();
    }
}
