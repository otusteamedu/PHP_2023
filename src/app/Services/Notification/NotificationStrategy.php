<?php
declare(strict_types=1);

namespace App\Services\Notification;

use App\Models\Event;
use App\Models\Subscriber;

abstract class NotificationStrategy
{
    abstract public function send(Event $event, Subscriber $subscriber): void;
}

