<?php
declare(strict_types=1);

namespace App\EventSystem;

use RedisApp\EventStorage\EventStorageInterface;
use RedisApp\Event\Event;

class EventSystem
{


    public function __construct(private EventStorageInterface $eventStorage)
    {
    }

    public function addEvent(Event $event)
    {
        $this->eventStorage->addEvent($event);
    }

    public function clearEvents()
    {
        $this->eventStorage->clearEvents();
    }

    public function findMatchingEvent($userParams)
    {
        return $this->eventStorage->findMatchingEvent($userParams);
    }
}