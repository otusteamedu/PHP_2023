<?php

namespace Order\App;

use Order\Infrastructure\AddOrderDTO;
use Symfony\Contracts\EventDispatcher\Event;

class OrderCreatedEvent extends Event
{
    const NAME = 'order.created';

    public function __construct(private AddOrderDTO $data)
    {
    }

    /**
     * @return AddOrderDTO
     */
    public function getData(): AddOrderDTO
    {
        return $this->data;
    }
}