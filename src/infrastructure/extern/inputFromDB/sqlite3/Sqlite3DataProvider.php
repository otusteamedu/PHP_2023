<?php

namespace src\infrastructure\extern\inputFromDB\sqlite3;

use src\PathHomeSource;

class Sqlite3DataProvider implements CreatorDBAdapterInterface
{
    public static function create(): Sqlite3DriverDBAdapter
    {
        $sqlQuery = 'select user, event, notify, sort from main.user_event_notify';

        return self::dbAdapterBuild($sqlQuery);
    }

    public static function queryUserSubscribes(): Sqlite3DriverDBAdapter
    {
        $sqlQuery = 'select user, type, value from main.user_subscribe';

        return self::dbAdapterBuild($sqlQuery);
    }

    public static function queryNotify(): Sqlite3DriverDBAdapter
    {
        $sqlQuery = 'select uid, name from main.notify';

        return self::dbAdapterBuild($sqlQuery);
    }

    public static function queryEvent(): Sqlite3DriverDBAdapter
    {
        $sqlQuery = 'select uid, name from main.event';

        return self::dbAdapterBuild($sqlQuery);
    }

    public static function queryUsers(): Sqlite3DriverDBAdapter
    {
        $sqlQuery = 'select uid, name from main.user';

        return self::dbAdapterBuild($sqlQuery);
    }

    private static function dbAdapterBuild(string $sqlQuery): Sqlite3DriverDBAdapter
    {
        $path = implode(
            DIRECTORY_SEPARATOR,
            [PathHomeSource::get(), 'var', 'db', 'db.sqlite']
        );

        return Sqlite3DriverDBAdapter::build()
            ->setSource($path)
            ->setQuery($sqlQuery);
    }
}
