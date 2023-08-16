<?php

namespace IilyukDmitryi\App\Application\UseCase;

use IilyukDmitryi\App\Application\Dto\FindEventRequest;
use IilyukDmitryi\App\Application\Dto\FindEventResponse;
use IilyukDmitryi\App\Domain\Repository\EventRepositoryInterface;
use IilyukDmitryi\App\Domain\ValueObject\Params;

class FindEventUseCase
{
    private EventRepositoryInterface $repository;
    
    public function __construct(EventRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function exec(FindEventRequest $findEventRequest): FindEventResponse
    {
        $params = Params::createFromArray($findEventRequest->getParams());
        $eventModel = $this->repository->findTopByParams($params);
        
        return new FindEventResponse($eventModel);
    }
}
