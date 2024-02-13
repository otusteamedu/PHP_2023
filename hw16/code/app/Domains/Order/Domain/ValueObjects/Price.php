<?php

namespace App\Domains\Order\Domain\ValueObjects;

use http\Exception\InvalidArgumentException;

class Price
{
    private int $price;
    public function __construct(int $price)
    {
        $this->assertValidPrice($price);
        $this->price = $price;
    }

    public function getValue(): int
    {
        return $this->price;
    }

    private function assertValidPrice(int $price): void
    {
        if ($price < 0 || $price > 10000) {
            throw new InvalidArgumentException('Цена на ингридиет не валидна');
        }
    }

}
