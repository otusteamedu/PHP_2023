<?php

namespace Gkarman\Datamaper\Models\User;

class UserCollection
{
    private array $users = [];

    public function add(User $user): void
    {
        $this->users[] = $user;
    }

    public function getAll(): array
    {
        return $this->users;
    }
}
