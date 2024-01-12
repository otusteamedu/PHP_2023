<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Response\CheckFinishedMessage;

use OpenApi\Attributes as OAT;

#[OAT\Schema]
class Transaction
{
    #[OAT\Property(
        property: 'accountNumber',
        description: 'Account number',
        type: 'string',
        example: '1234567890123456',
    )]
    #[OAT\Property(
        property: 'amount',
        description: 'Amount',
        type: 'string',
        example: '100.00',
    )]
    #[OAT\Property(
        property: 'currency',
        description: 'Currency',
        type: 'string',
        example: 'EUR',
    )]
    #[OAT\Property(
        property: 'date',
        description: 'Date',
        type: 'string',
        example: '2021-01-01',
    )]
    #[OAT\Property(
        property: 'description',
        description: 'Description',
        type: 'string',
        example: 'Test',
    )]
    public function __construct(
        public readonly string $accountNumber,
        public readonly string $amount,
        public readonly string $currency,
        public readonly string $date,
        public readonly string $description,
    ) {
    }

    public function toArray(): array
    {
        return [
            'accountNumber' => $this->accountNumber,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'date' => $this->date,
            'description' => $this->description,
        ];
    }
}
