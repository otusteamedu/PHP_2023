<?php

namespace src\users\numb;

use src\interface\KeyableUserInterface;
use src\interface\NameableUserInterface;

class UserNumb implements NameableUserInterface, KeyableUserInterface
{
    private const key = 5;

    public function __construct(private readonly string $name)
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
