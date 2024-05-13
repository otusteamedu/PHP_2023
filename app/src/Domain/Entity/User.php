<?php

declare(strict_types=1);

namespace AYamaliev\Hw16\Domain\Entity;

class User
{
    public function __construct(private string $username)
    {
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
