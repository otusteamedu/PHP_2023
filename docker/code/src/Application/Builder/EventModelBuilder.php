<?php

namespace IilyukDmitryi\App\Application\Builder;

use IilyukDmitryi\App\Application\Dto\CreateEventRequest;
use IilyukDmitryi\App\Domain\Model\EventModel;
use IilyukDmitryi\App\Domain\ValueObject\Event;
use IilyukDmitryi\App\Domain\ValueObject\Params;
use IilyukDmitryi\App\Domain\ValueObject\Priority;

class EventModelBuilder
{
    public static function createFromRequest(CreateEventRequest $createEventRequest): EventModel
    {
        $event = new Event($createEventRequest->getEvent());
        $priority = new Priority($createEventRequest->getPriority());
        $params = Params::createFromArray($createEventRequest->getParams());
        return new EventModel($event, $priority, $params);
    }
}
