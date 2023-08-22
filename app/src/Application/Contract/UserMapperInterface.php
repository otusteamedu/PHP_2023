<?php

declare(strict_types=1);

namespace App\Application\Contract;

use App\Application\DTO\RegisterUserRequest;
use App\Domain\Model\User;

interface UserMapperInterface
{
    public function findById(int $id): User;

    public function insert(RegisterUserRequest $registerUserRequest): User;
}
