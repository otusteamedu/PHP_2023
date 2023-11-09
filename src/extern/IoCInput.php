<?php

namespace src\extern;

use src\interface\FetchableArrayInterface;

class IoCInput
{
    public static function create(string $class): FetchableArrayInterface
    {
        return new $class();
    }
}
