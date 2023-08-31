<?php

declare(strict_types=1);

namespace App\Music\Domain\Factory;

use App\Music\Domain\Entity\User;

class UserFactory
{

    public function create(string $email, string $password): User
    {
        return new User($email, $password);
    }
}