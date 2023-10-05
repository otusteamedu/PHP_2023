<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\User;

use App\Application\UseCase\User\Create\CreateUserInput;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\NotEmptyString;

final class ConsoleCreateUserInput implements CreateUserInput
{
    public function __construct(
        private readonly Email $email,
        private readonly NotEmptyString $password,
    ) {
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): NotEmptyString
    {
        return  $this->password;
    }
}
