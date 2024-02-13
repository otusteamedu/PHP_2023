<?php

namespace App\Domains\Order_1\Domain\Repository;

use App\Domains\Order_1\Domain\Models\Order;

interface OrderRepositoryInterface
{
    public function create(Order $order): int;
}
