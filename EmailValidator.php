<?php

declare(strict_types=1);

final class EmailValidator
{
    public function validate(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $domain = substr(strrchr($email, "@"), 1);

        if (!checkdnsrr($domain)) {
            return false;
        }

        return true;
    }
}
