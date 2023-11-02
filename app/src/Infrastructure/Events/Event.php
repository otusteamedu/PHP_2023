<?php

namespace App\Infrastructure\Events;

use App\Infrastructure\QueryResult\DatabaseQueryResult;

class Event
{
    private DatabaseQueryResult $queryResult;

    public function __construct(DatabaseQueryResult $queryResult)
    {
        $this->queryResult = $queryResult;
    }

    public function __toString()
    {
        return static::class;
    }

    public function getQueryResult(): DatabaseQueryResult
    {
        return $this->queryResult;
    }
}
