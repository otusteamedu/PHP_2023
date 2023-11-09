<?php

namespace src\users\numb;

use src\interface\KeyableUserInterface;
use src\interface\NameableUserInterface;

class BossNumb implements NameableUserInterface, KeyableUserInterface {
    private const key = 3;
    private const captionRole = 'boss';

    public function getName(): string {
        return self::captionRole;
    }

    public function getKey(): string {
        return self::key;
    }
}
