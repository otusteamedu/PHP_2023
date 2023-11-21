<?php

namespace Tests\Repository;

use App\Infrastructure\Repository\SomeRepositoryInterface;

class DummyRepositoryNegative implements SomeRepositoryInterface
{
    public function setOrderIsPaid(string $orderNumber, float $sum): bool
    {
        return false;
    }
}
