<?php

declare(strict_types=1);

namespace Iosh\EmailValidator;

class Validator
{
    const EMAIL_REGEX = '[\w-\.]+@([\w-]+\.)+[\w-]{2,4}';

    public static function validateText(string $text): array
    {
        $result = [];
        foreach (static::findByRegex($text) as $email) {
            if (static::checkMx($email)) {
                $result[] = $email;
            }
        }
        return $result;
    }

    public static function validateSingle(string $email): bool
    {
        return static::checkRegex($email) && static::checkMx($email);
    }

    private function __construct(string $email)
    {
    }

    private static function findByRegex($text)
    {
        preg_match('/' . static::EMAIL_REGEX . '/', $text, $result);
        return $result;
    }

    private static function checkRegex($email): bool
    {
        return preg_match('/^' . static::EMAIL_REGEX . '$/', $email);
    }

    private static function checkMx(string $email)
    {
        $dummy = [];
        return getmxrr(explode('@', $email)[1], $dummy);
    }
}
