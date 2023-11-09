<?php

namespace src\users\numb;

use src\interface\KeyableUserInterface;
use src\interface\NameableUserInterface;

class EmperorNumb implements NameableUserInterface, KeyableUserInterface
{
    private const key = 6;
    function __construct(private readonly string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getKey(): string
    {
        return self::key;
    }
}
