<?php

declare(strict_types=1);

namespace App\Application\Component\PasswordHash;

use App\Domain\ValueObject\NotEmptyString;

final class PasswordHashValidator
{
    public function validate(NotEmptyString $password, NotEmptyString $hash): bool
    {
        return password_verify($password->getValue(), $hash->getValue());
    }
}
