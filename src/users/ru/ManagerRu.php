<?php

namespace src\users\ru;

use src\interface\NameableUserInterface;

class ManagerRu implements NameableUserInterface
{
    const nameDefault = 'менеджер';

    public function getName(): string
    {
        return $this::nameDefault;
    }
}
