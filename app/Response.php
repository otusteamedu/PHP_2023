<?php

namespace app;

class Response
{
    public static function stringResponse(string $string): string
    {
        return $string . PHP_EOL;
    }
}
