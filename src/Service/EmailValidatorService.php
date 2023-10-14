<?php

declare(strict_types=1);

namespace App\Service;

class EmailValidatorService
{
    public function validateEmail(string $email): bool
    {
        if (($this->isValidEmail($email)) === false) {
            return false;
        }

        if (!$this->hasMXRecord($email)) {
            return false;
        }

        return true;
    }

    private function isValidEmail(string $email): bool
    {
        return (bool) preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/', $email);
    }

    private function hasMXRecord(string $email): bool
    {
        $domain = substr($email, strpos($email, '@') + 1);

        return checkdnsrr($domain, 'MX');
    }
}
