<?php

namespace src\extern\inputFromDB\sqlite3;

use src\extern\InsertDataInterface;
use src\PathHomeSource;

class Sqlite3DataProvider implements CreatorDBAdapterInterface
{
    public static function create(): DBAdapterInterface
    {
        $path = implode(
            DIRECTORY_SEPARATOR,
            [PathHomeSource::get(), 'db', 'cnf.sqlite']
        );
        $sqlQuery = 'select user_id, event, notify from subscribers';
        return Sqlite3DriverDBAdapter::build()
            ->setSource($path)
            ->setQuery($sqlQuery);
    }

    public static function querySubscribersForUser(
        string $userId,
        string $event
    ): DBAdapterInterface {
        $path = implode(
            DIRECTORY_SEPARATOR,
            [PathHomeSource::get(), 'db', 'cnf.sqlite']
        );
        $where = sprintf("user_id=%s AND event='%s'", $userId, $event);
        $sqlQuery = 'select user_id, event, notify from subscribers where ' . $where;
        return Sqlite3DriverDBAdapter::build()
            ->setSource($path)
            ->setQuery($sqlQuery);
    }

    public static function insert(
        string $userId,
        string $event,
        string $notify
    ): DBAdapterInterface {
        $path = implode(
            DIRECTORY_SEPARATOR,
            [PathHomeSource::get(), 'db', 'cnf.sqlite']
        );
        $params = sprintf("(%s, '%s', '%s')", $userId, $event, $notify);

        $sqlQuery = 'INSERT INTO subscribers (user_id, event, notify) VALUES ' . $params;

        return Sqlite3DriverDBAdapter::build()
            ->setSource($path)
            ->setQuery($sqlQuery);
    }
}
