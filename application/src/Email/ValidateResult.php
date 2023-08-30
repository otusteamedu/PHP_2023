<?php

declare(strict_types=1);

namespace Gesparo\Hw\Email;

class ValidateResult
{
    private string $email;
    private bool $isValid;

    public function __construct(string $email, bool $isValid)
    {
        $this->email = $email;
        $this->isValid = $isValid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getIsValid(): bool
    {
        return $this->isValid;
    }
}
