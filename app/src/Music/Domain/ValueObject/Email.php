<?php

declare(strict_types=1);

namespace App\Music\Domain\ValueObject;

use App\Music\Domain\Exception\EmailValidationException;

class Email
{
    private string $value;

    public function __construct(string $email)
    {
        $this->validate($email);
        $this->value = $email;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function validate(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailValidationException('email value ' . $email . ' is invalid');
        }
    }
}
