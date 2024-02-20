<?php

namespace App\Domains\Order\Infrastructure\Repository;

use App\Domains\Order\Domain\Entity\Order\AbstractOrder;
use App\Domains\Order\Domain\Entity\Product\AbstractProduct;
use App\Domains\Order\Domain\Repositories\OrderRepositoryInterface;
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
        // получение id сохраненного заказа
    }

    public function getById(int $orderId): AbstractOrder
    {
        // получение заказа по id
    }

    public function saveProductToOrder(AbstractOrder $order, AbstractProduct $product): void
    {
        // сохранение продуктов заказа
    }
}
