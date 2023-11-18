<?php

namespace src\domain\user\fabric;

use src\domain\user\User;
use src\domain\user\UserInterface;

class IoCUser
{
    public static function create(string $id): UserInterface
    {
        return new User($id);
    }
}
