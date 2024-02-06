<?php

namespace App\Domain\User\Domain\Repository;

use App\Domain\User\Domain\Model\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(string $id): ?User;

    public function findByEmail(string $email): ?User;
}
