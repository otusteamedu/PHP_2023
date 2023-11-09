<?php

namespace src\users\numb;

use src\interface\KeyableUserInterface;
use src\interface\NameableUserInterface;

class ManagerNumb implements NameableUserInterface, KeyableUserInterface
{
    private const key = 2;
    private const captionRole = 'manager';

    public function getName(): string
    {
        return self::captionRole;
    }

    public function getKey(): string
    {
        return self::key;
    }
}
