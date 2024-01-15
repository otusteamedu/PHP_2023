<?php

namespace Order\App;

use Order\App\Event\OrderCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class ConsoleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            OrderCreatedEvent::NAME => 'onOrderCreatedEvent',
        ];
    }

    public function onOrderCreatedEvent(OrderCreatedEvent $event): void
    {
        echo 'ConsoleSubscriber: ' . $event->getData()->email . ': [' . $event->getData()->from->format('Y-m-d H:i:s') . '] -> [' . $event->getData()->to->format('Y-m-d H:i:s') . ']' . PHP_EOL;
    }
}
