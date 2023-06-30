<?php
declare(strict_types=1);

namespace App\Services\Notification;

use App\Models\Event;
use App\Models\Subscriber;

class SmsNotificationStrategy extends NotificationStrategy
{
    public function send(Event $event, Subscriber $subscriber): void
    {
        // код отправки уведомления по СМС
    }
}
