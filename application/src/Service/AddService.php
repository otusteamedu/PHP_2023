<?php

declare(strict_types=1);

namespace Gesparo\HW\Service;

use Gesparo\HW\Event\EventList;
use Gesparo\HW\Storage\AddInterface;

class AddService
{
    private EventList $eventList;
    private AddInterface $storage;

    public function __construct(EventList $eventList, AddInterface $storage)
    {
        $this->eventList = $eventList;
        $this->storage = $storage;
    }

    public function add(): void
    {
        $this->storage->add($this->eventList);
    }
}