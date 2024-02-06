<?php

namespace App\Domain\User\Application;

use App\Domain\User\Domain\Model\User;
use App\Domain\User\Domain\Repository\UserRepositoryInterface;

class CreateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    public function createUser(string $name, string $email): User
    {
        $user = new User($name, $email);
        $this->userRepository->save($user);
        return $user;
    }
}
