<?php

declare(strict_types=1);

namespace Yalanskiy\EmailValidator;

/**
 * Class Validator
 */
class Validator
{
    /**
     * Validate email address
     * @param string $email
     *
     * @return bool
     */
    public static function validate(string $email): bool
    {
        $email = trim($email);

        if (empty($email)) {
            return false;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        $domain = explode('@', $email)[1];
        return getmxrr($domain, $mxHosts);
    }
}
