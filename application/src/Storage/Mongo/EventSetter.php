<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\Mongo;

use Gesparo\HW\Event\Event;
use MongoDB\Collection;

class EventSetter
{
    private Collection $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function set(Event $event): void
    {
        $this->collection->insertOne([
            'event' => $event->getEvent(),
            'priority' => $event->getPriority(),
            'conditions' => $event->getConditions(),
        ]);
    }
}
