<?php

declare(strict_types=1);

namespace Kanakhin\EmailValidation\Domain;

class Email
{
    private string $email;

    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function emailCorrect(): bool
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $parts = explode('@', $this->email);

        if (count($parts) != 2 || !checkdnsrr($parts[1], 'MX')) {
            return false;
        }

        return true;
    }
}