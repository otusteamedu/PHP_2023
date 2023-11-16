<?php

namespace src\fabric;

use src\user\User;
use src\user\UserInterface;

class IoCUser
{
    public static function create(string $id): UserInterface
    {
        return new User($id);
    }
}
