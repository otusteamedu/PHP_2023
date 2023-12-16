<?php

declare(strict_types=1);

namespace Gesparo\Homework\ValueObject;

use Gesparo\Homework\AppException;

class BankStatementRequest
{
    private string $accountNumber;
    private \DateTime $startDate;
    private \DateTime $endDate;

    /**
     * @throws AppException
     */
    public function __construct(string $accountNumber, \DateTime $startDate, \DateTime $endDate)
    {
        $this->validate($accountNumber, $startDate, $endDate);

        $this->accountNumber = $accountNumber;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @throws AppException
     */
    private function validate(string $accountNumber, \DateTime $startDate, \DateTime $endDate): void
    {
        if ('' === $accountNumber) {
            throw AppException::accountNumberNotValid($accountNumber);
        }

        if ($startDate > $endDate) {
            throw AppException::startDateGreaterThanEndDate($startDate, $endDate);
        }
    }
}