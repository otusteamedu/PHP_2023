<?php

namespace src\extern\inputFromDB;

use src\extern\inputFromDB\sqlite3\CreatorDBAdapterInterface;
use src\extern\inputFromDB\sqlite3\DBAdapterInterface;

class IoCDataProvider {
    public static function create(string $class): CreatorDBAdapterInterface {
        return $class();
    }
}
