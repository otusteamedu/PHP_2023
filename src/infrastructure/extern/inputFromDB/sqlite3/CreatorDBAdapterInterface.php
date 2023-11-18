<?php

namespace src\infrastructure\extern\inputFromDB\sqlite3;

interface CreatorDBAdapterInterface
{
    public static function create(): DBAdapterInterface;
}
