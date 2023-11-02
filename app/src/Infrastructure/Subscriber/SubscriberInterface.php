<?php

namespace App\Infrastructure\Subscriber;

use App\Infrastructure\Events\Event;

interface SubscriberInterface
{
    public function update(Event $event): void;
}
