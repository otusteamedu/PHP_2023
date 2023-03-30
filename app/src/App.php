<?php

declare(strict_types=1);

namespace Aporivaev\Hw06;

class App
{
    public static function validateEmails(): string
    {
        return json_encode(EmailValidator::validation(self::inputParams()), JSON_UNESCAPED_UNICODE) ."\n";
    }

    private static function inputParams(): array
    {
        global $argv, $argc;

        if (isset($argc) && isset($argv) && is_array($argv)) {
            if ($argc > 1) {
                return array_slice($argv, 1);
            }
        }

        return [ 'email@email.email', 'email@email.com', 'email@example.com', 'email.email', 'email+1@example.com',
            'email-1@example.com', 'email=1@example.com', 'email\1@example.com', 'email*1@example.com'];
    }

}
