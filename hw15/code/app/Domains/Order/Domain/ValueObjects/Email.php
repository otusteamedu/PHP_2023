<?php

namespace App\Domains\Order\Domain\ValueObjects;

use http\Exception\InvalidArgumentException;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        $this->assertValidEmail($email);
        $this->email = $email;
    }

    public function getValue(): string
    {
        return $this->email;
    }

    private function assertValidEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Поле email некорректно');
        }
    }
}
