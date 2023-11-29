<?php

namespace App;

class EmailVerifier
{
    public function verifyEmail(string $email): bool
    {
        $regex = '/^[\w\.\-]+@[\w\.\-]+\.[a-zA-Z]{2,}$/';

        if (!preg_match($regex, $email)) {
            return false;
        }

        $domain = substr(strrchr($email, "@"), 1);

        if (!checkdnsrr($domain, 'MX')) {
            return false;
        }

        return true;
    }

    public function verifyEmails(array $emails): array
    {
        $validEmails = [];
        foreach ($emails as $email) {
            if ($this->verifyEmail($email)) {
                $validEmails[] = $email;
            }
        }
        return $validEmails;
    }
}
