<?php

namespace App\Infrastructure\Repository;

class SomeRepository implements SomeRepositoryInterface
{
    public function setOrderIsPaid(string $orderNumber, float $sum): bool
    {
        //TODO
        return true;
    }
}
