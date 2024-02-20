<?php

namespace App\Domains\Order\Domain\Notifications\ProductChangeStatusNotifications;

use App\Domains\Order\Domain\Entity\Product\AbstractProduct;

class PushToClientNotify extends ProductChangeStatusNotificationHandler
{
    public function handle(AbstractProduct $product): void
    {
        $this->sendPushToClient();
        parent::handle($product);
    }

    private function sendPushToClient(): void
    {
        // отправление пуш уведомления клиенту заказа
    }
}
