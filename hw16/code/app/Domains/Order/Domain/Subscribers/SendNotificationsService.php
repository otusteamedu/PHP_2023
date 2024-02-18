<?php

namespace App\Domains\Order\Domain\Subscribers;

use App\Domains\Order\Domain\Notifications\ProductChangeStatusNotifications\PushToClientNotify;
use App\Domains\Order\Domain\Notifications\ProductChangeStatusNotifications\PushToStaffNotify;

class SendNotificationsService implements ProductChangeStatusSubscriberInterface
{
    public function run(): void
    {
        $notifyFirst = new PushToClientNotify();
        $notifySecond = new PushToStaffNotify();
        $notifyFirst->setNext($notifySecond);

        $notifyFirst->handle();
    }
}
