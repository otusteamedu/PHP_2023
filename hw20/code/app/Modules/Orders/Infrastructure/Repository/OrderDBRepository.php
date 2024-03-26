<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Repository;

use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Modules\Orders\Infrastructure\Models\OrderModel;

class OrderDBRepository implements OrderRepositoryInterface
{
    public function save(Order $order): void
    {
        $model = new OrderModel();
        $model->uuid = $order->getUuid()->getValue();
        $model->email = $order->getEmail()->getValue();
        $model->comment = $order->getComment()->getValue();
        $model->save();
    }
}
