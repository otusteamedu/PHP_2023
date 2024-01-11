<?php

declare(strict_types=1);

namespace Gesparo\Homework\Domain\ValueObject;

use Gesparo\Homework\AppException;
use Ramsey\Uuid\Uuid;

class PublisherBankStatementResponse
{
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';

    private string $accountNumber;
    private \DateTime $startDate;
    private \DateTime $endDate;
    private string $messageId;
    private string $status;
    private string $reason;
    /** @var Transaction[] */
    private array $transactions;

    /**
     * @param Transaction[] $transactions
     * @throws AppException
     */
    public function __construct(
        string $accountNumber,
        \DateTime $startDate,
        \DateTime $endDate,
        string $messageId,
        string $status,
        string $reason = '',
        array $transactions = []
    ) {
        $this->validate($accountNumber, $startDate, $endDate, $messageId, $status, $reason, $transactions);

        $this->accountNumber = $accountNumber;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->messageId = $messageId;
        $this->status = $status;
        $this->reason = $reason;
        $this->transactions = $transactions;
    }

    /**
     * @throws AppException
     */
    private function validate(
        string $accountNumber,
        \DateTime $startDate,
        \DateTime $endDate,
        string $messageId,
        string $status,
        string $reason,
        array $transactions
    ): void {
        if ('' === $accountNumber) {
            throw AppException::accountNumberNotValid($accountNumber);
        }

        if ($startDate > $endDate) {
            throw AppException::startDateGreaterThanEndDate($startDate, $endDate);
        }

        if (!in_array($status, [self::STATUS_SUCCESS, self::STATUS_FAILED], true)) {
            throw AppException::statusNotValid($status);
        }

        if (self::STATUS_FAILED === $status && '' === $reason) {
            throw AppException::reasonCannotBeEmpty();
        }

        if ('' === $messageId) {
            throw AppException::messageIdIsEmpty();
        }

        if (false === Uuid::isValid($messageId)) {
            throw AppException::messageIdNotValid($messageId);
        }

        foreach ($transactions as $transaction) {
            if (!$transaction instanceof Transaction) {
                throw AppException::transactionMustBeInstanceOfTransactionClass($transaction);
            }
        }
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getReason(): string
    {
        return $this->reason;
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }
}
