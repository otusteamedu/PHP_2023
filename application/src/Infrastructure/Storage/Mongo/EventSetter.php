<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Storage\Mongo;

use Gesparo\HW\Domain\Entity\Event;
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
        $databaseConditions = [];

        foreach ($event->getConditions() as $condition) {
            $databaseConditions[$condition->getName()] = $condition->getValue();
        }

        $this->collection->insertOne([
            'event' => $event->getName()->getValue(),
            'priority' => $event->getPriority()->getValue(),
            'conditions' => $databaseConditions,
        ]);
    }
}
