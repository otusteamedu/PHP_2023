<?php

declare(strict_types=1);

namespace App\Application\Component\PasswordHash;

use App\Domain\ValueObject\NotEmptyString;

final class PasswordHashGenerator
{
    public function generate(NotEmptyString $password): NotEmptyString
    {
        return new NotEmptyString(password_hash($password->getValue(), PASSWORD_BCRYPT));
    }
}
