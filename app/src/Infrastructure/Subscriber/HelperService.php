<?php

namespace App\Infrastructure\Subscriber;

use App\Infrastructure\Events\Event;

class HelperService implements SubscriberInterface
{
    public function update(Event $event): void
    {
        print_r($event . PHP_EOL);
    }
}
