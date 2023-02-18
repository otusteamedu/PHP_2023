<?php

declare(strict_types=1);

namespace Twent\EmailValidator;

use Twent\EmailValidator\Exceptions\EmptyEmailString;
use Twent\EmailValidator\Exceptions\MxRecordNotExists;
use Twent\EmailValidator\Exceptions\NotValidEmailString;

final class EmailValidator
{
    /**
     * @throws EmptyEmailString
     * @throws NotValidEmailString
     * @throws MxRecordNotExists
     */
    public static function handle(string ...$emails): bool
    {
        foreach ($emails as $email) {
            $email = trim(htmlspecialchars($email));

            if (! $email) {
                throw new EmptyEmailString();
            }

            self::checkSyntax($email);
            self::checkMxRecord($email);
        }

        return true;
    }

    /**
     * @throws NotValidEmailString
     */
    public static function checkSyntax(string $email): bool
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new NotValidEmailString($email);
        }

        return true;
    }

    /**
     * @throws MxRecordNotExists
     */
    public static function checkMxRecord(string $email): bool
    {
        [$username, $domain] = explode('@', $email);

        if (! checkdnsrr($domain)) {
            throw new MxRecordNotExists($domain);
        }

        return true;
    }
}
