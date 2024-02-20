<?php

namespace App\Domains\Order\Domain\Notifications\ProductChangeStatusNotifications;

use App\Domains\Order\Domain\Entity\Product\AbstractProduct;

class PushToStaffNotify extends ProductChangeStatusNotificationHandler
{
    public function handle(AbstractProduct $product): void
    {
        $this->sendPushToStaff();
        parent::handle($product);
    }

    private function sendPushToStaff(): void
    {
        // отправление пуш уведомления персоналу заказа
    }
}
