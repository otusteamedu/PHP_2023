<?php

namespace src\config\domain;

use src\domain\event\CompetitionEvent;
use src\domain\event\ConcertEvent;
use src\domain\event\ExhibitionEvent;

class EventsConfig
{
    public static function describes(): array
    {
        return [
            'concert' => ConcertEvent::class,
            'exhibition' => ExhibitionEvent::class,
            'competition' => CompetitionEvent::class,
        ];
    }
}
