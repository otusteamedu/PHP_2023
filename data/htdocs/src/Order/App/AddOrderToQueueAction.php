<?php

namespace Order\App;

use Order\Infrastructure\AddOrderDTO;
use Symfony\Component\Messenger\MessageBusInterface;
use function MongoDB\BSON\toJSON;

class AddOrderToQueueAction
{
    public function __construct(
        private MessageBusInterface $bus
    )
    {

    }

    public function execute(AddOrderDTO $data)
    {
        $this->bus->dispatch($data);
    }
}