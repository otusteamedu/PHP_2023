<?php

declare(strict_types=1);

namespace Singurix\Emailscheck;

class Validator
{
    public static function check(string $email): bool
    {
        if (
            preg_match(
                '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]{1,}@[a-zA-Z0-9-]{2,63}.[a-zA-Z]{2,63}$/',
                $email
            )
        ) {
            return self::checkDnsMx($email);
        } else {
            return false;
        }
    }

    private static function checkDnsMx(string $email): bool
    {
        list(, $domain) = explode('@', $email);
        return getmxrr($domain, $records);
    }
}
