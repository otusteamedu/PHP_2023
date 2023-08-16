<?php

namespace IilyukDmitryi\App\Application\UseCase;

use IilyukDmitryi\App\Application\Builder\EventModelBuilder;
use IilyukDmitryi\App\Application\Dto\CreateEventRequest;
use IilyukDmitryi\App\Application\Dto\CreateEventResponse;
use IilyukDmitryi\App\Domain\Repository\EventRepositoryInterface;

class AddEventUseCase
{
    private EventRepositoryInterface $repository;
    
    public function __construct(EventRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function exec(CreateEventRequest $createEventRequest): CreateEventResponse
    {
        /* $event = new Event($createEventRequest->getEvent());
         $priority = new Priority($createEventRequest->getPriority());
         $params =  Params::createFromArray($createEventRequest->getParams());
         $eventModel = new EventModel($event, $priority, $params);*/
        $eventModel = EventModelBuilder::createFromRequest($createEventRequest);
        $res = $this->repository->add($eventModel);
        
        return new CreateEventResponse($res);
    }
}
