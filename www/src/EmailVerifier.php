<?php

declare(strict_types=1);

namespace Chernomordov\App;

class EmailVerifier
{
    private array $emailList;

    public function __construct(string $emailList)
    {
        $this->emailList = explode(' ', $emailList);
    }

    public function verifyEmails(): array
    {
        $validEmails = [];

        foreach ($this->emailList as $email) {
            if ($this->isValidFormat($email) && $this->isValidMX($email)) {
                $validEmails[] = $email;
            }
        }

        return $validEmails;
    }

    private function isValidFormat($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function isValidMX($email): bool
    {
        list($username, $domain) = explode('@', $email);

        if (!checkdnsrr($domain, 'MX')) {
            return false;
        }

        return true;
    }
}
