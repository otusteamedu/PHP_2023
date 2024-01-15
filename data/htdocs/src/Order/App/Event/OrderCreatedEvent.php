<?php

namespace Order\App\Event;

use Order\App\AddOrderDTO;
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
