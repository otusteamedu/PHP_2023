<?php

declare(strict_types=1);

namespace Otus\App\Model;

use Otus\App\Database\IdentityInterface;

final class User implements IdentityInterface
{
    public function __construct(
        private readonly int $id,
        private string $name,
        private string $surname,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }
}
