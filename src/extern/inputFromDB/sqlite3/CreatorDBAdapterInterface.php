<?php

namespace src\extern\inputFromDB\sqlite3;

interface CreatorDBAdapterInterface
{
    public static function create(): DBAdapterInterface;
}
