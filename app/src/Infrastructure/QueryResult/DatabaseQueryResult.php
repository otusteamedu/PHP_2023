<?php

namespace App\Infrastructure\QueryResult;

use App\Infrastructure\Repository\Db;
use App\Infrastructure\Events\DatabaseQueryResultIsCreated;
use App\Infrastructure\Events\SqlIsExecuted;
use App\Infrastructure\Publisher\PublisherInterface;
use Exception;

class DatabaseQueryResult implements \Iterator
{
    protected Db $db;
    protected string $query;
    protected array $params;
    protected int $position;
    protected ?array $result = null;
    protected PublisherInterface $publisher;

    /**
     * @throws Exception
     */
    public function __construct($query, $params, PublisherInterface $publisher)
    {
        $this->db = Db::getInstance();
        $this->query = $query;
        $this->params = $params;
        $this->position = 0;
        $this->publisher = $publisher;

        $this->executeQuery();
        $this->publisher->notify(new DatabaseQueryResultIsCreated($this));
    }

    /**
     * @throws Exception
     */
    protected function executeQuery()
    {
        if (is_null($this->result)) {
            $this->result = $this->db->query($this->query, $this->params);
        }

        if (is_null($this->result)) {
            throw new Exception("Query execution error.");
        }

        $this->publisher->notify(new SqlIsExecuted($this));
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
