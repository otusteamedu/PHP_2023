<?php

declare(strict_types=1);

namespace Gesparo\Homework;

class AppException extends \Exception
{
    private const PATH_HELPER_NOT_INITIALIZED = 1;
    private const ENV_FILE_NOT_FOUND = 2;
    private const ENV_FILE_NOT_READABLE = 3;
    private const VALIDATION_ERROR = 4;
    private const ACCOUNT_NUMBER_NOT_VALID = 5;
    private const START_DATE_GREATER_THAN_END_DATE = 6;

    public static function pathHelperNotInitialized(): self
    {
        return new self('PathHelper is not initialized', self::PATH_HELPER_NOT_INITIALIZED);
    }

    public static function envFileNotFound(string $path): self
    {
        return new self(sprintf('Env file not found in path %s', $path), self::ENV_FILE_NOT_FOUND);
    }

    public static function envFileNotReadable(string $path): self
    {
        return new self(sprintf('Env file not readable in path %s', $path), self::ENV_FILE_NOT_READABLE);
    }

    public static function validationError(string $message): self
    {
        return new self($message, self::VALIDATION_ERROR);
    }

    public static function accountNumberNotValid(string $accountNumber): self
    {
        return new self(sprintf('Account number %s is not valid', $accountNumber), self::ACCOUNT_NUMBER_NOT_VALID);
    }

    public static function startDateGreaterThanEndDate(\DateTime $startDate, \DateTime $endDate): AppException
    {
        return new self(
            sprintf('Start date %s is greater than end date %s', $startDate->format('Y-m-d'), $endDate->format('Y-m-d')),
            self::START_DATE_GREATER_THAN_END_DATE
        );
    }
}
