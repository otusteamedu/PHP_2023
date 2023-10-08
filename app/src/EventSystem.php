<?php

/**
 * Класс системы событий
 */

namespace App;

use App\Storage\Storage;
use Exception;

class EventSystem
{
    private Storage $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @throws Exception
     */
    public function addEvent(int $priority, array $conditions, mixed $event): void
    {
        $this->storage->add($priority, $conditions, $event);
    }

    /**
     * @throws Exception
     */
    public function clearEvents(): void
    {
        $this->storage->clear();
    }

    /**
     * @throws Exception
     */
    public function getEvent($params)
    {
        return $this->storage->get($params);
    }
}
