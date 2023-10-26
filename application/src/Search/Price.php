<?php

declare(strict_types=1);

namespace Gesparo\ES\Search;

use Gesparo\ES\AppException;

class Price
{
    private int $price;

    /**
     * @throws AppException
     */
    public function __construct(int $price)
    {
        $this->price = $price;
        $this->assertPrice();
    }

    public function get(): int
    {
        return $this->price;
    }

    /**
     * @throws AppException
     */
    private function assertPrice(): void
    {
        if ($this->price < 0) {
            throw AppException::priceCannotBeLessThanZero($this->price);
        }
    }
}