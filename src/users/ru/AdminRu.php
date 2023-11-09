<?php

namespace src\users\ru;

use src\interface\NameableUserInterface;

class AdminRu implements NameableUserInterface
{
    protected const nameDefault = '1роль-админ';

    public function getName(): string
    {
        return $this::nameDefault;
    }
}
