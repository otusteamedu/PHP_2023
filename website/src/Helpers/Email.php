<?php

namespace App\Helpers;

class Email
{
    protected static array $DNS = [];

    public static function validateEmails(array $emails = []): array
    {
        $result = [];
        foreach ($emails as $email) {
            $result[] = filter_var($email, FILTER_VALIDATE_EMAIL) && static::checkDNS($email);
        }

        return array_combine($emails, $result);
    }

    public static function checkDNS(string $email): bool
    {
        $domain = substr(strrchr($email, '@'), 1);
        if (isset(static::$DNS[$domain])) {
            return static::$DNS[$domain];
        }

        try {
            $resultEmail = getmxrr($domain, $mx_records) && count($mx_records) > 0;
        } catch (\RuntimeException $e) {
            $resultEmail = false;
        }

        static::$DNS[$domain] = $resultEmail;
        return $resultEmail;
    }
}