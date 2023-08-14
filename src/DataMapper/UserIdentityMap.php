<?php

declare(strict_types=1);

namespace Ro\Php2023\DataMapper;

use Ro\Php2023\Models\User;

class UserIdentityMap
{
    private array $identityMap = [];

    public function addUser(User $user): void
    {
        $this->identityMap[$user->getId()] = $user;
    }

    public function getUserById(int $user_id): ?User
    {
        return $this->identityMap[$user_id] ?? null;
    }
}
