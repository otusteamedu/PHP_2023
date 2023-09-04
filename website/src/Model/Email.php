<?php

namespace App\Model;

class Email
{
    private bool $isValid = false;

    public function __construct(private readonly string $email)
    {
    }

    public function __toString(): string
    {
        return sprintf("%s: %s", $this->email, $this->isValid ? 'valid' : 'not valid');
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): void
    {
        $this->isValid = $isValid;
    }
}
