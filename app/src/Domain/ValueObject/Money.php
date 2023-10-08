<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final class Money
{
    public function __construct(
        private readonly Number $amount,
        private readonly Currency $currency,
    ) {
    }

    public function getAmount(): Number
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
