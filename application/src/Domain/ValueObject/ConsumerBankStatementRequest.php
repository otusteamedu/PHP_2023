<?php

declare(strict_types=1);

namespace Gesparo\Homework\Domain\ValueObject;

use Gesparo\Homework\AppException;
use Ramsey\Uuid\Uuid;

class ConsumerBankStatementRequest
{
    private string $accountNumber;
    private \DateTime $startDate;
    private \DateTime $endDate;
    private string $messageId;

    /**
     * @throws AppException
     */
    public function __construct(string $accountNumber, \DateTime $startDate, \DateTime $endDate, string $messageId)
    {
        $this->validate($accountNumber, $startDate, $endDate, $messageId);

        $this->accountNumber = $accountNumber;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->messageId = $messageId;
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

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    /**
     * @throws AppException
     */
    private function validate(string $accountNumber, \DateTime $startDate, \DateTime $endDate, string $messageId): void
    {
        if ('' === $accountNumber) {
            throw AppException::accountNumberNotValid($accountNumber);
        }

        if ($startDate > $endDate) {
            throw AppException::startDateGreaterThanEndDate($startDate, $endDate);
        }

        if ('' === $messageId) {
            throw AppException::messageIdIsEmpty();
        }

        if (false === Uuid::isValid($messageId)) {
            throw AppException::messageIdNotValid($messageId);
        }
    }
}
