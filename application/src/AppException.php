<?php

declare(strict_types=1);

namespace Gesparo\Homework;

use Throwable;

class AppException extends \Exception
{
    private const PATH_HELPER_NOT_INITIALIZED = 1;
    private const ENV_FILE_NOT_FOUND = 2;
    private const ENV_FILE_NOT_READABLE = 3;
    public const VALIDATION_ERROR = 4;
    private const ACCOUNT_NUMBER_NOT_VALID = 5;
    private const START_DATE_GREATER_THAN_END_DATE = 6;
    public const STATEMENT_REQUEST_WAS_NOT_SUCCESSFUL = 7;
    private const MESSAGE_ID_NOT_VALID = 8;
    private const MESSAGE_ID_IS_EMPTY = 9;
    private const STATUS_NOT_VALID = 10;
    private const REASON_CANNOT_BE_EMPTY = 11;
    private const AMOUNT_NOT_VALID = 12;
    private const CURRENCY_NOT_VALID = 13;
    private const DESCRIPTION_NOT_VALID = 14;
    private const TRANSACTION_MUST_BE_INSTANCE_OF_TRANSACTION_CLASS = 15;
    private const INVALID_CONTROLLER = 16;
    private const CANNOT_SCAN_PROJECT_FOR_GETTING_DOCUMENTATION = 17;

    private array $data;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, array $data = [])
    {
        parent::__construct($message, $code, $previous);

        $this->data = $data;
    }

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

    public static function validationError(array $errors): self
    {
        return new self('Validation error', self::VALIDATION_ERROR, null, $errors);
    }

    public static function accountNumberNotValid(string $accountNumber): self
    {
        return new self(sprintf('Account number %s is not valid', $accountNumber), self::ACCOUNT_NUMBER_NOT_VALID);
    }

    public static function startDateGreaterThanEndDate(\DateTime $startDate, \DateTime $endDate): self
    {
        return new self(
            sprintf('Start date %s is greater than end date %s', $startDate->format('Y-m-d'), $endDate->format('Y-m-d')),
            self::START_DATE_GREATER_THAN_END_DATE
        );
    }

    public static function statementRequestWasNotSuccessful(string $messageId): self
    {
        return new self("Statement request with id '$messageId' was not successful", self::STATEMENT_REQUEST_WAS_NOT_SUCCESSFUL);
    }

    public static function messageIdNotValid(string $messageId): self
    {
        return new self(sprintf('Message id %s is not valid', $messageId), self::MESSAGE_ID_NOT_VALID);
    }

    public static function messageIdIsEmpty(): self
    {
        return new self('Message id is empty', self::MESSAGE_ID_IS_EMPTY);
    }

    public static function statusNotValid(string $status): self
    {
        return new self(sprintf('Status %s is not valid', $status), self::STATUS_NOT_VALID);
    }

    public static function reasonCannotBeEmpty(): self
    {
        return new self('Reason cannot be empty', self::REASON_CANNOT_BE_EMPTY);
    }

    public static function amountNotValid(string $amount): self
    {
        return new self(sprintf('Amount %s is not valid', $amount), self::AMOUNT_NOT_VALID);
    }

    public static function currencyNotValid(string $currency): self
    {
        return new self(sprintf('Currency %s is not valid', $currency), self::CURRENCY_NOT_VALID);
    }

    public static function descriptionNotValid(string $description): self
    {
        return new self(sprintf('Description %s is not valid', $description), self::DESCRIPTION_NOT_VALID);
    }

    public static function transactionMustBeInstanceOfTransactionClass(mixed $transaction): self
    {
        return new self(
            sprintf("Transaction '%s' must be instance of Transaction class", gettype($transaction)),
            self::TRANSACTION_MUST_BE_INSTANCE_OF_TRANSACTION_CLASS
        );
    }

    public function getData(): array
    {
        return $this->data;
    }

    public static function invalidController(string $controller): self
    {
        return new self(sprintf('Controller %s is not valid', $controller), self::INVALID_CONTROLLER);
    }

    public static function cannotScanProjectForGettingDocumentation(string $path): self
    {
        return new self(sprintf('Cannot scan project for documentation in path %s', $path), self::CANNOT_SCAN_PROJECT_FOR_GETTING_DOCUMENTATION);
    }
}
