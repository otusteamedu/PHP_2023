<?php

namespace src\fabric;

use src\event\CompetitionEvent;
use src\event\ConcertEvent;
use src\event\EventInterface;
use src\event\ExhibitionEvent;
use src\exception\NotExistEventException;

class IoCEvent
{
    public static function create(string $typeEvent): EventInterface
    {
        $events = [
            'competition' => CompetitionEvent::class,
            'concert' => ConcertEvent::class,
            'exhibition' => ExhibitionEvent::class,
        ];

        $type = strtolower($typeEvent);
        if (!isset($events[$type])) {
            throw new NotExistEventException($type);
        }

        return new $events[$type]();
    }
}
