<?php

declare(strict_types=1);

namespace Santonov\Otus;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\Extra\SpoofCheckValidation;
use Egulias\EmailValidator\Validation\NoRFCWarningsValidation;

final class Validator
{
    public static function isEmailValid(string $email, bool $strict): bool
    {
        if ($strict) {
            return self::strictEmailValidation($email);
        }

        if (empty($email)) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE)) {
            return false;
        }

        $host = $email;
        if (false !== $lastPos = strpos($email, '@')) {
            $host = substr($email, $lastPos + 1);
        }

        if (!checkdnsrr($host, 'MX')) {
            return false;
        }

        return true;
    }

    private static function strictEmailValidation(string $email): bool
    {
        $externalEmailValidator = new EmailValidator();
        if (!$externalEmailValidator->isValid($email, new NoRFCWarningsValidation())) {
            return false;
        }

        if (!$externalEmailValidator->isValid($email, new SpoofCheckValidation())) {
            return false;
        }

        if (!$externalEmailValidator->isValid($email, new DNSCheckValidation())) {
            return false;
        }

        return true;
    }
}
