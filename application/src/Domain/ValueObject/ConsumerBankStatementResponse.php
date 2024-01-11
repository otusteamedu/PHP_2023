<?php

declare(strict_types=1);

namespace Gesparo\Homework\Domain\ValueObject;

use Gesparo\Homework\AppException;

class ConsumerBankStatementResponse
{
    private string $accountNumber;
    private \DateTime $startDate;
    private \DateTime $endDate;
    private string $status;
    private string $reason;
    /**
     * @var Transaction[]
     */
    private array $transactions;

    /**
     * @param Transaction[] $transactions
     * @throws AppException
     */
    public function __construct(
        string $accountNumber,
        \DateTime $startDate,
        \DateTime $endDate,
        string $status,
        string $reason = '',
        array $transactions = []
    )
    {
        $this->validate($accountNumber, $startDate, $endDate, $status, $reason, $transactions);

        $this->accountNumber = $accountNumber;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
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

        if (!in_array($status, [PublisherBankStatementResponse::STATUS_SUCCESS, PublisherBankStatementResponse::STATUS_FAILED], true)) {
            throw AppException::statusNotValid($status);
        }

        if (PublisherBankStatementResponse::STATUS_FAILED === $status && '' === $reason) {
            throw AppException::reasonCannotBeEmpty();
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
