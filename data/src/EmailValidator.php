<?php
declare(strict_types=1);

namespace EgorPotopakhin\EmailValidator;

class EmailValidator
{
    public static function validate(string $email): bool {
        list(, $domain) = explode("@", $email);
        return  filter_var($email, FILTER_VALIDATE_EMAIL) && checkdnsrr($domain);
    }
}