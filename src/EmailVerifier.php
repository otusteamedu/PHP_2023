<?php

declare(strict_types=1);

namespace Daniel\Otus;

class EmailVerifier
{
    private array $valid_emails;

    private const VERIFY_EMAILS = [
        'test@example.com',
        'invalid-email@',
        'valid.email@domain.com'
    ];

    public function verifyEmail(string $email): bool
    {
        $regex = '/^[\w\.\-]+@[\w\.\-]+\.[a-zA-Z]{2,}$/';

        if (!preg_match($regex, $email)) {
            return false;
        }

        $domain = substr(strrchr($email, "@"), 1);

        if (!checkdnsrr($domain)) {
            return false;
        }

        return true;
    }

    public function verifyEmails(): void
    {
        foreach (self::VERIFY_EMAILS as $email) {
            if ($this->verifyEmail($email)) {
                $this->valid_emails[] = $email;
            }
        }
    }

    public function printValidEmails(): void
    {
        echo "Valid emails:\n";
        print_r($this->valid_emails);
    }
}
