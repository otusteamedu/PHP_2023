<?php

namespace App\Event;

use App\Storage\Storage;

class EventSystem
{
    private Storage $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function addEvent($priority, $conditions, $event)
    {
        $this->storage->add($priority, $conditions, $event);
    }

    public function clearEvents()
    {
        $this->storage->clear();
    }

    public function getEvent($params)
    {
        return $this->storage->get($params);
    }
}
