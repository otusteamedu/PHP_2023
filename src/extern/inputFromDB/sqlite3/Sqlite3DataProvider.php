<?php

namespace src\extern\inputFromDB\sqlite3;

use src\PathHomeSource;

class Sqlite3DataProvider implements CreatorDBAdapterInterface {
    public static function create(): DBAdapterInterface {
        $path = implode(
            DIRECTORY_SEPARATOR,
            [PathHomeSource::get(), '..', 'db', 'cnf.sqlite']
        );
        $sqlQuery = 'select id, name, aliases, active, with_name from person';
        return Sqlite3DriverDBAdapter::build()
            ->setSource($path)
            ->setQuery($sqlQuery);
    }
}
