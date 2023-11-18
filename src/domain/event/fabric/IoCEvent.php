<?php

namespace src\domain\event\fabric;

use src\config\domain\EventsConfig;
use src\domain\event\EventInterface;
use src\domain\event\exception\NotExistEventException;

class IoCEvent
{
    public static function create(string $typeEvent): EventInterface
    {
        $events = self::describes();

        $type = strtolower($typeEvent);
        if (!isset($events[$type])) {
            throw new NotExistEventException($type);
        }

        return new $events[$type]();
    }

    private static function describes(): array
    {
        return EventsConfig::describes();
    }
}
