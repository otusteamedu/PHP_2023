<?php

namespace src\users\ru;

use src\interface\NameableUserInterface;

class NameableUserRu implements NameableUserInterface
{
    function __construct(private readonly string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
