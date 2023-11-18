<?php

namespace src\infrastructure\extern\inputFromDB;

use src\infrastructure\extern\FetchArrayInterface;
use src\infrastructure\extern\FetchDataArrayInterface;
use src\infrastructure\extern\inputFromDB\sqlite3\LinkDBTransformer;
use src\infrastructure\extern\inputFromDB\sqlite3\Sqlite3DataProvider;

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
