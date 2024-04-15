<?php

namespace Dmitry\Hw16\Application\Publisher;

class Publisher implements PublisherInterface
{

    private $subscribers = [];

    public function subscribe(SubscriberInterface $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function unsubscribe(SubscriberInterface $subscriber): void
    {
        // TODO: Implement unsubscribe() method.
    }

    public function notify($product, $status)
    {
        var_dump($product->getName() . ' - ' . $status);
        foreach ($this->subscribers as $subscriber) {
            $subscriber->notify($product, $status);
        }
    }
}