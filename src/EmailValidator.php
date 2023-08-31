<?php

declare(strict_types=1);

namespace RomanK\Php2023;

class EmailValidator
{
    public function validateEmail(array $emails): array
    {
        $validEmails = [];
        $invalidEmails = [];
        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !checkdnsrr($email)) {
                $invalidEmails[] = $email;
            } else {
                $validEmails[] = $email;
            };
        }

        return [
            'invalidEmails' => $invalidEmails,
            'validEmails' => $validEmails
        ];
    }
}