<?php

namespace Order\App;

use Order\Infrastructure\AddOrderDTO;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\Event;

class OrderHandler
{
    public function __invoke(AddOrderDTO $data)
    {
        // Событие перед обработкой
        /**
         * @var EventDispatcher $eventDispatcher
         */
        $eventDispatcher = container()->get(EventDispatcherInterface::class);
        $eventDispatcher->dispatch(new OrderCreatedEvent($data), OrderCreatedEvent::NAME);
//        $eventDispatcher->addSubscriber(new \Order\Infrastructure\SendEmailSubscriber());

//        $eventDispatcher->dispatch();
        // Отправка уведомления
        //// Добавление в очередь
        // Событие после обработки
    }
}