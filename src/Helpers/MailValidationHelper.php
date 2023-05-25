<?php

declare(strict_types=1);

namespace Art\Php2023\Helpers;

use Exception;

class MailValidationHelper
{
    public static function checkEmailList(array $request): array
    {
        isset($request['emails']) &&
            $request['emails'] !== '' ?: throw new Exception('Запрос пустой!');
        $request = json_decode($request['emails'], true);
        gettype($request) === 'array' ||
            gettype($request) === 'object' ?: throw new Exception('Не правильный формат списка!');
        $validMails = [];
        foreach ($request as $email) {
            if (!self::checkInRegExp($email)) {
                $validMails[$email][] = 'FALSE, not pass filter validation email';
            }
            if (!self::checkInFilterValidate($email)) {
                $validMails[$email][] = 'FALSE, not pass regular expression';
            }
            if (!self::checkInDns($email)) {
                $validMails[$email][] = 'FALSE, not pass DNS check';
            }
            if (!isset($validMails[$email])) {
                $validMails[$email] = true;
            }
        }

        return $validMails;
    }

    private static function checkInRegExp(string $email): bool
    {
        $pattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
        return (preg_match($pattern, $email) === 1) ? true : false;
    }

    private static function checkInFilterValidate(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
    }

    private static function checkInDns(string $email): bool
    {
        $atPos = mb_strpos($email, '@');
        $domain = mb_substr($email, $atPos + 1);

        return checkdnsrr($domain . '.', 'MX') ? true : false;
    }
}
