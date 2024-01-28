<?php

declare(strict_types=1);

namespace Dimal\Hw12;

use Dimal\Hw12\Event;

abstract class EventStorage
{
    abstract public function addEvent(Event $event): void;

    abstract public function searchEvent(EventConditions $conditions): ?Event;

    abstract public function clearEvents(): void;
}