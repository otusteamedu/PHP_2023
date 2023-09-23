<?php

declare(strict_types=1);

namespace App\Music\Domain\ValueObject;

use App\Music\Domain\Exception\PasswordValidationException;

class Password
{
    private string $value;

    public function __construct(string $password)
    {
        $this->validate($password);
        $this->value = $password;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function validate(string $password): void
    {
        if (strlen($password) < 8) {
            throw new PasswordValidationException(
                'password must contains minimum eight characters'
            );
        }
    }
}
