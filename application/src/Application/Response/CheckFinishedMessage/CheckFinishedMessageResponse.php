<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Response\CheckFinishedMessage;

class CheckFinishedMessageResponse
{
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_FINISHED = 'finished';
    public const STATUS_FAILED = 'failed';

    /**
     * @param Transaction[] $transactions
     */
    public function __construct(
        public readonly string $status,
        public readonly ?string $accountNumber = null,
        public readonly ?string $startDate = null,
        public readonly ?string $endDate = null,
        public readonly ?string $reason = null,
        public readonly array $transactions = []
    )
    {
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'accountNumber' => $this->accountNumber,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'reason' => $this->reason,
            'transactions' => array_map(static fn(Transaction $transaction) => $transaction->toArray(), $this->transactions)
        ];
    }
}
