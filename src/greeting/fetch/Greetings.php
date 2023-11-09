<?php

namespace src\greeting\fetch;

use src\greeting\create\IoCGreeting;
use src\greeting\GreetingEmperor;
use src\greeting\GreetingPerson;

class Greetings
{
    public static function fetch(): array
    {
        return [
            0 => IoCGreeting::create(GreetingPerson::class),
            1 => IoCGreeting::create(GreetingEmperor::class),
        ];
    }
}
