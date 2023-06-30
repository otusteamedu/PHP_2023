<?php
declare(strict_types=1);

namespace App\Services\Notification;

use App\Models\Event;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Log;

class LoggingNotificationDecorator extends NotificationStrategy
{
    private NotificationStrategy $strategy;

    public function __construct(NotificationStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function send(Event $event, Subscriber $subscriber): void
    {
        Log::info("Sending notification for event {$event->id} to subscriber {$subscriber->id}");

        $this->strategy->send($event, $subscriber);

        Log::info("Notification for event {$event->id} was sent to subscriber {$subscriber->id}");
    }
}
