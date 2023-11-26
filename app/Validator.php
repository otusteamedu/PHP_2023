<?php

namespace app;

class Validator
{
    public static function validateEmail(string $email): bool
    {
        list(, $domain) = explode('@', $email);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) && checkdnsrr($domain)) {
            return true;
        }

        return false;
    }
}
