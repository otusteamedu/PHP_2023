<?php

declare(strict_types=1);

namespace Myklon\Hw5\Services;

class EmailValidator
{
    public static function validate(): bool
    {
        foreach ($_POST['emails'] as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("$email. Invalid email format.");
            }

            $emailParts = explode('@', $email);
            $domain = $emailParts[1];

            if (!checkdnsrr($domain, 'MX')) {
                throw new \Exception("$email. Invalid MX record for the domain of the email address.");
            }
        }
        return true;
    }
}
