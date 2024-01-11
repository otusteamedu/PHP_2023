<?php

declare(strict_types=1);

namespace Gesparo\Homework\Domain\ValueObject;

use Gesparo\Homework\AppException;

class Transaction
{
    public const CURRENCY_EUR = 'EUR';
    private string $accountNumber;
    private string $amount;
    private string $currency;
    private \DateTime $date;
    private string $description;

    /**
     * @throws AppException
     */
    public function __construct(
        string $accountNumber,
        string $amount,
        string $currency,
        \DateTime $date,
        string $description
    ) {
        $this->validate($accountNumber, $amount, $currency, $description);

        $this->accountNumber = $accountNumber;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->date = $date;
        $this->description = $description;
    }

    /**
     * @throws AppException
     */
    private function validate(string $accountNumber, string $amount, string $currency, string $description): void
    {
        if ('' === $accountNumber) {
            throw AppException::accountNumberNotValid($accountNumber);
        }

        if ('' === $amount || !is_numeric($amount)) {
            throw AppException::amountNotValid($amount);
        }

        if ('' === $currency || self::CURRENCY_EUR !== $currency) {
            throw AppException::currencyNotValid($currency);
        }

        if ('' === $description) {
            throw AppException::descriptionNotValid($description);
        }
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
