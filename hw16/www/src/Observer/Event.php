<?php

namespace Shabanov\Otusphp\Observer;

use Shabanov\Otusphp\Interfaces\ObserverInterface;
use Shabanov\Otusphp\Interfaces\ProductInterface;

class Event
{
    private array $subscribers = [];
    public function __construct() {}

    public function addSubscriber(ObserverInterface $subscriber): self
    {
        $this->subscribers[] = $subscriber;
        return $this;
    }

    public function removeSubscriber(ObserverInterface $subscriber): void
    {
        $index = array_search($subscriber, $this->subscribers);
        if ($index !== false) {
            unset($this->subscribers[$index]);
        }
    }

    public function notifySubscribers(ProductInterface $product, string $status): void
    {
        foreach($this->subscribers as $subscriber) {
            $subscriber->update($product, $status);
        }
    }
}
