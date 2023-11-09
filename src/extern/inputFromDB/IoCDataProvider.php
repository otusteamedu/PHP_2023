<?php

namespace src\extern\inputFromDB;

use src\extern\inputFromDB\sqlite3\CreatorDBAdapterInterface;

class IoCDataProvider
{
    public static function create(string $class): CreatorDBAdapterInterface
    {
        return $class();
    }
}
