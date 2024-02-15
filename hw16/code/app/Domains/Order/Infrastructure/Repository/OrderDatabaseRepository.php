<?php

namespace App\Domains\Order\Infrastructure\Repository;

use App\Domains\Order\Domain\Entity\Order\AbstractOrder;
use App\Domains\Order\Domain\Repository\OrderRepositoryInterface;
use App\Domains\Order\Infrastructure\Models\OrderModel;

class OrderDatabaseRepository implements OrderRepositoryInterface
{
    public function __construct(
        private OrderModel $orderModel,
    )
    {
    }

    public function create(AbstractOrder $order): int
    {
        return 1;
    }
}
