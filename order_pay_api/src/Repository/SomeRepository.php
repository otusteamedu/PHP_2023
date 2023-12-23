<?php

namespace App\Repository;

class SomeRepository implements SomeRepositoryInterface
{
    public function setOrderIsPaid(string $orderNumber, float $sum): bool
    {
        //TODO: will add success pay in DB
        return true;
    }
}
