<?php

namespace App\Model;

interface StorageInterface
{
    public function addEvent(Event $event);
    public function clearEvents();
    public function findMatchingEvent(array $params);
}
