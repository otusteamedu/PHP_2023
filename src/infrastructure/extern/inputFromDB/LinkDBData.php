<?php

namespace src\infrastructure\extern\inputFromDB;

use src\infrastructure\extern\FetchDataArrayInterface;
use src\infrastructure\extern\FetchArrayInterface;
use src\infrastructure\extern\FetchDataQueryInterface;
use src\infrastructure\extern\inputFromDB\sqlite3\LinkDBTransformer;
use src\infrastructure\extern\inputFromDB\sqlite3\Sqlite3DataProvider;

class LinkDBData implements FetchDataQueryInterface
{
    public function fetchAll(): array
    {
        $accData = Sqlite3DataProvider::create()
            ->fetch()
            ->getData();

        return LinkDBTransformer::transform($accData);
    }

    public function fetchUserSubscribes(): array
    {
        $accData = Sqlite3DataProvider::queryUserSubscribes()
            ->fetch()
            ->getData();

        return $accData;
    }

    public function fetchNotify(): array
    {
        $accData = Sqlite3DataProvider::queryNotify()
            ->fetch()
            ->getData();

        return $accData;
    }

    public function fetchEvent(): array
    {
        $accData = Sqlite3DataProvider::queryEvent()
            ->fetch()
            ->getData();

        return $accData;
    }

    public function fetchUsers(): array
    {
        $accData = Sqlite3DataProvider::queryUsers()
            ->fetch()
            ->getData();

        return $accData;
    }
}
