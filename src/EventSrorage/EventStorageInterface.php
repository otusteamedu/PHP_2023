<?php

namespace RedisApp\EventStorage;

use RedisApp\Event\Event;

interface EventStorageInterface
{
    public function addEvent(Event $event);

    public function clearEvents();

    public function findMatchingEvent($userParams);
}