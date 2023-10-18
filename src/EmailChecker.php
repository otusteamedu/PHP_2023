<?php

declare(strict_types=1);

namespace src;

class EmailChecker
{
    public function verification(string $email): void
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }
        throw new EmailIsNotValidException();
    }

    public function verificationByDNS(string $email)
    {
        list(, $domain) = explode('@', $email);
        if (checkdnsrr($domain, 'MX')) {
            return;
        }
        throw new EmailIsNotValidException();
    }
}
