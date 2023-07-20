<?php

namespace App\Model;

class EventSystem
{
    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function addEvent(int $priority, array $conditions, $event)
    {
        $eventObj = new Event($priority, $conditions, $event);
        $this->storage->addEvent($eventObj);
    }

    public function clearEvents()
    {
        $this->storage->clearEvents();
    }

    public function findMatchingEvent(array $params)
    {
        return $this->storage->findMatchingEvent($params);
    }
}
