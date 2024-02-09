<?php

namespace App\Domain\Contract;

use App\Domain\DTO\EventSourcesDTO;

interface EventFilterInterface
{
    public static function filterEventsBySources(EventSourcesDTO $eventFilterDto): array;
}