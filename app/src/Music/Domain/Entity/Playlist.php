<?php

declare(strict_types=1);

namespace App\Music\Domain\Entity;

class Playlist
{
    private int $id;
    private string $name;
    private User $user;

    public function __construct(string $name, User $user)
    {
        $this->name = $name;
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
