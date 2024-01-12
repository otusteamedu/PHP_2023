<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Response\CheckFinishedMessage;

use OpenApi\Attributes as OAT;

#[OAT\Schema]
class CheckFinishedMessageResponse
{
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_FINISHED = 'finished';
    public const STATUS_FAILED = 'failed';

    /**
     * @param Transaction[] $transactions
     */
    #[OAT\Property(
        property: 'status',
        description: 'Status',
        type: 'string',
        enum: [self::STATUS_PROCESSING, self::STATUS_FINISHED, self::STATUS_FAILED],
        example: self::STATUS_PROCESSING,
    )]
    #[OAT\Property(
        property: 'accountNumber',
        description: 'Account number',
        type: 'string',
        example: '1234567890123456',
    )]
    #[OAT\Property(
        property: 'startDate',
        description: 'Start date',
        type: 'string',
        example: '2021-01-01',
    )]
    #[OAT\Property(
        property: 'endDate',
        description: 'End date',
        type: 'string',
        example: '2022-01-01',
    )]
    #[OAT\Property(
        property: 'reason',
        description: 'Reason',
        type: 'string',
        example: 'Account number is invalid',
    )]
    #[OAT\Property(
        property: 'transactions',
        description: 'Transactions',
        type: 'array',
        items: new OAt\Items(
            ref: 'components/schemas/Transaction'
        )
    )]
    public function __construct(
        public readonly string $status,
        public readonly ?string $accountNumber = null,
        public readonly ?string $startDate = null,
        public readonly ?string $endDate = null,
        public readonly ?string $reason = null,
        public readonly array $transactions = []
    ) {
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
