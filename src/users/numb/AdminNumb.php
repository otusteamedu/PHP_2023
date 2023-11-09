<?php

namespace src\users\numb;

use src\interface\KeyableUserInterface;
use src\interface\NameableUserInterface;

class AdminNumb implements NameableUserInterface, KeyableUserInterface
{
    private const key = 4;
    private const captionRole = 'admin';

    public function getName(): string
    {
        return self::captionRole;
    }

    public function getKey(): string
    {
        return self::key;
    }
}
