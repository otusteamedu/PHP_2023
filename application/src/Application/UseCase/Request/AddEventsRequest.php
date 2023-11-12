<?php

declare(strict_types=1);

namespace Gesparo\HW\Application\UseCase\Request;

class AddEventsRequest
{
    /**
     * @param EventDTO[] $events
     */
    public function __construct(public readonly array $events)
    {
    }
}
