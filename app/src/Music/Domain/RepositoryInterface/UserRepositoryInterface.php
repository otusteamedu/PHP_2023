<?php

declare(strict_types=1);

namespace App\Music\Domain\RepositoryInterface;

use App\Music\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function add(User $user): void;

    public function findById(string $id): ?User;
}