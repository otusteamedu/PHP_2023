<?php

namespace src\users\numb;

use src\interface\KeyableUserInterface;
use src\interface\NameableUserInterface;

class GuestNumb implements NameableUserInterface, KeyableUserInterface
{
    private const key = 1;
    private const captionRole = 'guest';

    public function getName(): string
    {
        return self::captionRole;
    }

    public function getKey(): string
    {
        return self::key;
    }
}
