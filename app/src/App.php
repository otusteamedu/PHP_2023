<?php

namespace App;

use App\Application\Dto\ConditionsDto;
use App\Application\Dto\EventDto;
use App\Application\EventGatewayInterface;
use App\Application\UseCase\CreateEventUseCase;
use App\Application\UseCase\GetEventUseCase;
use App\Domain\Entity\Event;
use Exception;

class App
{
    private EventGatewayInterface $eventProvider;

    public function __construct(EventGatewayInterface $eventProvider)
    {
        $this->eventProvider = $eventProvider;
    }

    /**
     * @throws Exception
     */
    public function createEvent(EventDto $eventDto, ConditionsDto $conditionsDto): void
    {
        $createEventUseCase = new CreateEventUseCase($this->eventProvider);
        $createEventUseCase->create($eventDto, $conditionsDto);
    }

    /**
     * @throws Exception
     */
    public function getEvent(ConditionsDto $conditionsDto): ?Event
    {
        $getEventUseCase = new GetEventUseCase($this->eventProvider);
        return $getEventUseCase->get($conditionsDto);
    }
}
