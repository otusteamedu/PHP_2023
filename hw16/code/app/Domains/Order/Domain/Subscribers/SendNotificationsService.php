<?php

namespace App\Domains\Order\Domain\Subscribers;

use App\Domains\Order\Domain\Entity\Product\AbstractProduct;
use App\Domains\Order\Domain\Notifications\ProductChangeStatusNotifications\PushToClientNotify;
use App\Domains\Order\Domain\Notifications\ProductChangeStatusNotifications\PushToStaffNotify;

class SendNotificationsService implements ProductChangeStatusSubscriberInterface
{
    public function run(AbstractProduct $product): void
    {
        $notifyFirst = new PushToClientNotify();
        $notifySecond = new PushToStaffNotify();
        $notifyFirst->setNext($notifySecond);

        $notifyFirst->handle($product);
    }
}
