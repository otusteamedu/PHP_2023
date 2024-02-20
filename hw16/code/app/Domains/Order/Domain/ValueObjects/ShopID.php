<?php

namespace App\Domains\Order\Domain\ValueObjects;

use http\Exception\InvalidArgumentException;

class ShopID
{
    private int $shopId;

    public function __construct(int $shopId)
    {
        $this->assertValidShopId($shopId);
        $this->shopId = $shopId;
    }

    public function getValue(): int
    {
        return $this->shopId;
    }

    private function assertValidShopId(int $shopId): void
    {
        if (!in_array($shopId, [1, 2, 3])) {
            throw new InvalidArgumentException('Id магазина не валидно');
        }
    }

}
