<?php

namespace Tests\Repository;

use App\Infrastructure\Repository\SomeRepositoryInterface;

class DummyRepositoryPositive implements SomeRepositoryInterface
{
    public function setOrderIsPaid(string $orderNumber, float $sum): bool
    {
        return true;
    }
}
