<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Repository;

use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Modules\Orders\Domain\ValueObject\Comment;
use App\Modules\Orders\Domain\ValueObject\Email;
use App\Modules\Orders\Domain\ValueObject\UUID;
use App\Modules\Orders\Infrastructure\Models\OrderModel;

class OrderDBRepository implements OrderRepositoryInterface
{
    public function create(Order $order): void
    {
        $model = new OrderModel();
        $model->uuid = $order->getUuid()->getValue();
        $model->email = $order->getEmail()->getValue();
        $model->comment = $order->getComment()->getValue();
        $model->save();
    }

    public function update(Order $order): void
    {
         OrderModel::query()
            ->where('uuid', $order->getUuid()->getValue())
            ->update([
                'email' => $order->getEmail()->getValue(),
                'comment' =>  $order->getComment()->getValue(),
            ]);
    }

    public function getList(): array
    {
        $orders = OrderModel::query()
            ->get()
            ->toArray();

        return $orders;
    }

    public function findByUuid(UUID $uuid): ?Order
    {
        $orderModel = OrderModel::find($uuid->getValue());
        if (!$orderModel) {
            return null;
        }

        return new Order(
            new UUID($orderModel->uuid),
            new Email($orderModel->email),
            new Comment($orderModel->comment),
        );
    }

    public function deleteByUuid(UUID $uuid): void
    {
        OrderModel::query()
            ->where('uuid', $uuid->getValue())
            ->delete();
    }
}
