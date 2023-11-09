<?php

namespace src\greeting\create;

use src\interface\GreetingInterface;

class IoCGreeting
{
    public static function create(string $greetingName): GreetingInterface
    {
        return new $greetingName();
    }
}
