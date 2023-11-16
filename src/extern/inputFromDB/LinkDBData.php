<?php

namespace src\extern\inputFromDB;

use src\extern\FetchArrayInterface;
use src\extern\FetchDataArrayInterface;
use src\extern\inputFromDB\sqlite3\LinkDBTransformer;
use src\extern\inputFromDB\sqlite3\Sqlite3DataProvider;

class LinkDBData implements FetchArrayInterface, FetchDataArrayInterface
{
    public function fetch(): array
    {
        $accData = Sqlite3DataProvider::create()
            ->fetch()
            ->getData();

        return LinkDBTransformer::transform($accData);
    }

    public function fetchData(string $userId, string $eventType): array
    {
        $accData = Sqlite3DataProvider::querySubscribersForUser(
            $userId,
            $eventType
        )
            ->fetch()
            ->getData();

        return LinkDBTransformer::transform($accData);
    }
}
