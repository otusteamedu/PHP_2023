<?php

declare(strict_types=1);

namespace App\Repository;

interface SomeRepositoryInterface
{
    public function setOrderIsPaid(string $orderNumber, float $sum): bool;
}
