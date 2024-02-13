<?php

namespace App\Domains\Order\Infrastructure\Repository;

use App\Domains\Order\Domain\Entity\AbstractOrder;
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
        $this->orderModel->title = $order->getTitle()->getValue();
        $this->orderModel->description = $order->getDescription()->getValue();
        $this->orderModel->email = $order->getEmail()->getValue();
        $this->orderModel->save();
        return $this->orderModel->id;
    }
}
