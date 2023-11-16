<?php

namespace src\log;

class Log
{
    public static function info(string $message): void
    {
        echo $message;
        echo PHP_EOL;
    }

    public static function warning(string $message): void
    {
        echo 'WARNING: ' . $message;
        echo PHP_EOL;
    }

    public static function error(string $message): void
    {
        echo 'ERROR: ' . $message;
        echo PHP_EOL;
    }
}
