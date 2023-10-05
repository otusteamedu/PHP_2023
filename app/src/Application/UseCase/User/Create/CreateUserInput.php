<?php

declare(strict_types=1);

namespace App\Application\UseCase\User\Create;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\NotEmptyString;

interface CreateUserInput
{
    public function getEmail(): Email;

    public function getPassword(): NotEmptyString;
}
