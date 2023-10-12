<?php

declare(strict_types=1);

namespace App\Application\UseCase\User;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\NotEmptyString;

interface AuthenticateUserInput
{
    public function getEmail(): Email;

    public function getPassword(): NotEmptyString;
}
