<?php

namespace src\users;

use src\interface\NameableUserInterface;

class Admin implements NameableUserInterface
{
    protected const nameDefault = 'admin';// 'role-super-admin'

    public function getName(): string
    {
        return $this::nameDefault;
    }
}
