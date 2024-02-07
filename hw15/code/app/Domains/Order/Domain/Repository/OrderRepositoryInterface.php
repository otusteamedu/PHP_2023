<?php

namespace App\Domains\Order\Domain\Repository;

use App\Domains\Order\Domain\Models\Order;

interface OrderRepositoryInterface
{
    public function create(Order $order): int;
}
