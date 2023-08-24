<?php

declare(strict_types=1);

namespace App\Application\DTO;

class RegisterUserRequest
{
    public string $login;
    public string $password;
}
