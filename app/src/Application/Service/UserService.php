<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Contract\UserMapperInterface;
use App\Application\DTO\RegisterUserRequest;

class UserService
{
    private UserMapperInterface $userMapper;

    public function __construct(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    public function registerUser(RegisterUserRequest $registerUserRequest): string
    {
        $user = $this->userMapper->insert($registerUserRequest);
        return $user->getLogin()->getValue() . ' создан!';
    }
}
