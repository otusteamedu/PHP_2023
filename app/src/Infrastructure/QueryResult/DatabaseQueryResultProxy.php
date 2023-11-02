<?php

namespace App\Infrastructure\QueryResult;

use App\Infrastructure\Repository\Db;
use App\Infrastructure\Events\DatabaseQueryResultIsCreated;
use Exception;

class DatabaseQueryResultProxy extends DatabaseQueryResult
{
    public function __construct($query, $params, $publisher)
    {
        $this->db = Db::getInstance();
        $this->query = $query;
        $this->params = $params;
        $this->position = 0;
        $this->publisher = $publisher;

        $this->publisher->notify(new DatabaseQueryResultIsCreated($this));
    }

    /**
     * @throws Exception
     */
    public function rewind(): void
    {
        $this->executeQuery();
        parent::rewind();
    }
}
