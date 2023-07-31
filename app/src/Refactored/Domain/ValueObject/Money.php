<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\ValueObject;

use Imitronov\Hw15\Refactored\Domain\Constant\CurrencyCode;

final class Money
{
    private Number $amount;

    private CurrencyCode $currencyCode;

    public function __construct(Number $amount, CurrencyCode $currencyCode = CurrencyCode::RUB)
    {
        $this->amount = $amount;
        $this->currencyCode = $currencyCode;
    }

    public function getAmount(): Number
    {
        return $this->amount;
    }

    public function getAmountInCents(): int
    {
        return (int) $this->amount->mul(Number::hundred())->getValue();
    }

    public function getCurrencyCode(): CurrencyCode
    {
        return $this->currencyCode;
    }
}
