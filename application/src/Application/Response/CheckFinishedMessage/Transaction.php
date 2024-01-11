<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Response\CheckFinishedMessage;

class Transaction
{
    public function __construct(
        public readonly string $accountNumber,
        public readonly string $amount,
        public readonly string $currency,
        public readonly string $date,
        public readonly string $description,
    )
    {
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
