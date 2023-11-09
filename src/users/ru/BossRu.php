<?php

namespace src\users\ru;

use src\interface\NameableUserInterface;

class BossRu implements NameableUserInterface
{
    const nameDefault = '1роль-босс';

    public function getName(): string
    {
        return $this::nameDefault;
    }
}
