<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class EmailIsNotValidException extends Exception implements UserExceptionInterface
{
    private function __construct(private readonly string $userMessage)
    {
        parent::__construct('email is not valid');
    }

    public function getUserMessage(): string
    {
        return $this->userMessage;
    }

    public static function absentA(): EmailIsNotValidException
    {
        return new EmailIsNotValidException('absent "@"');
    }

    public static function localPartLengthExceeded(): EmailIsNotValidException
    {
        return new EmailIsNotValidException('local part length exceeded');
    }

    public static function domainPartLengthExceeded(): EmailIsNotValidException
    {
        return new EmailIsNotValidException('domain part length exceeded');
    }

    public static function localPartStartsOrEndsWithDot(): EmailIsNotValidException
    {
        return new EmailIsNotValidException('local part starts or ends with "."');
    }

    public static function localPartHasTwoConsecutiveDots(): EmailIsNotValidException
    {
        return new EmailIsNotValidException('local part has two consecutive dots');
    }

    public static function characterNotValidInDomainPart(): EmailIsNotValidException
    {
        return new EmailIsNotValidException('character not valid in domain part');
    }

    public static function domainPartHasTwoConsecutiveDots(): EmailIsNotValidException
    {
        return new EmailIsNotValidException('domain part has two consecutive dots');
    }

    public static function domainNotFoundInDns(): EmailIsNotValidException
    {
        return new EmailIsNotValidException('domain not found in DNS');
    }

    public static function characterNotValidInLocalPart(): EmailIsNotValidException
    {
        return new EmailIsNotValidException('character not valid in local part unless local part is quoted');
    }
}