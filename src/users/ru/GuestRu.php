<?php

namespace src\users\ru;

use src\interface\NameableUserInterface;

class GuestRu implements NameableUserInterface
{
    const nameDefault = '1гость';

    public function getName(): string
    {
        return $this::nameDefault;
    }
}
