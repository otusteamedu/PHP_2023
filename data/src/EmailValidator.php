<?php
declare(strict_types=1);

namespace EgorPotopakhin\Web;

class EmailValidator
{
    public static function validate(string $email): bool {
        list(, $domain) = explode("@", $email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && checkdnsrr($domain)) {
            return true;
        } else {
            return  false;
        }
    }
}