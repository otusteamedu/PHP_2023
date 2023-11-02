<?php

namespace App\Infrastructure\Publisher;

use App\Infrastructure\Events\Event;
use App\Infrastructure\Subscriber\SubscriberInterface;

interface PublisherInterface
{
    public function subscribe(SubscriberInterface $subscriber): void;
    public function unsubscribe(SubscriberInterface $subscriber): void;
    public function notify(Event $event): void;
}
