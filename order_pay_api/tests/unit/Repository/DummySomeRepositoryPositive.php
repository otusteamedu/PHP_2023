<?php

declare(strict_types=1);

namespace unit\Repository;

use App\Repository\SomeRepositoryInterface;

class DummySomeRepositoryPositive implements SomeRepositoryInterface
{

    public function setOrderIsPaid(string $orderNumber, float $sum): bool
    {
        return true;
    }
}
