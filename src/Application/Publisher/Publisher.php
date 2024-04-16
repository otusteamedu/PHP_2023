<?php

namespace Dmitry\Hw16\Application\Publisher;

class Publisher implements PublisherInterface
{
    private $subscribers = [];

    public function subscribe(SubscriberInterface $subscriber): void
    {
        $this->subscribers[spl_object_id($subscriber)] = $subscriber;
    }

    public function unsubscribe(SubscriberInterface $subscriber): void
    {
        unset($this->subscribers[spl_object_id($subscriber)]);
    }

    public function notify($product, $status)
    {
        var_dump($product->getName() . ' - ' . $status);
        foreach ($this->subscribers as $subscriber) {
            $subscriber->notify($product, $status);
        }
    }
}
