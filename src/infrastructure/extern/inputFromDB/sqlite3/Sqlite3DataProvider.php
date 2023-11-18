<?php

namespace src\infrastructure\extern\inputFromDB\sqlite3;

use src\PathHomeSource;

class Sqlite3DataProvider implements CreatorDBAdapterInterface
{
    public static function create(): DBAdapterInterface
    {
        $sqlQuery = 'select user_id, event, notify from subscribers';
        return Sqlite3DriverDBAdapter::build()
            ->setSource(self::getPath())
            ->setQuery($sqlQuery);
    }

    public static function querySubscribersForUser(
        string $userId,
        string $event
    ): DBAdapterInterface {
        $where = sprintf("user_id=%s AND event='%s'", $userId, $event);
        $sqlQuery = 'select user_id, event, notify from subscribers where ' . $where;
        return Sqlite3DriverDBAdapter::build()
            ->setSource(self::getPath())
            ->setQuery($sqlQuery);
    }

    public static function insert(
        string $userId,
        string $event,
        string $notify
    ): DBAdapterInterface {
        $params = sprintf("(%s, '%s', '%s')", $userId, $event, $notify);
        $sqlQuery = 'INSERT INTO subscribers (user_id, event, notify) VALUES ' . $params;
        return Sqlite3DriverDBAdapter::build()
            ->setSource(self::getPath())
            ->setQuery($sqlQuery);
    }

    private static function getPath(): string
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [PathHomeSource::get() , 'var', 'db', 'cnf.sqlite']
        );
    }
}
