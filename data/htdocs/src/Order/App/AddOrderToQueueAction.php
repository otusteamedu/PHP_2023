<?php

namespace Order\App;

use Symfony\Component\Messenger\MessageBusInterface;

class AddOrderToQueueAction
{
    public function __construct(
        private MessageBusInterface $bus
    ) {
    }

    public function execute(AddOrderDTO $data)
    {
        $this->bus->dispatch($data);
    }
}
