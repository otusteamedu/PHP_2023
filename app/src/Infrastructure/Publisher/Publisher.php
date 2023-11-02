<?php

namespace App\Infrastructure\Publisher;

use App\Infrastructure\Events\Event;
use App\Infrastructure\Subscriber\SubscriberInterface;

class Publisher implements PublisherInterface
{
    private array $subscribers = [];

    public function subscribe(SubscriberInterface $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function unsubscribe(SubscriberInterface $subscriber): void
    {
        foreach ($this->subscribers as $k => $v) {
            if ($v === $subscriber) {
                break;
            }
        }
        unset($k);
    }

    public function notify(Event $event): void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($event);
        }
    }
}
