<?php

declare(strict_types=1);

namespace Services;

class EmailValidator
{
    public function validate(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        list($username, $domain) = explode('@', $email);

        if (getmxrr($domain, $mxHosts)) {
            return true;
        } else {
            return false;
        }
    }
}
