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
    private array $events;

    public function __construct(EventGatewayInterface $eventProvider)
    {
        $this->events = json_decode(file_get_contents(__DIR__ . '/events.json'), true);
        $this->eventProvider = $eventProvider;
    }

    /**
     * @throws Exception
     */
    public function add(): void
    {
        foreach ($this->events as $event) {
            $eventDto = new EventDto($event['priority'], $event['name']);
            $conditionsDto = new ConditionsDto($event['conditions']);

            try {
                $this->createEvent($eventDto, $conditionsDto);
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }
    }

    /**
     * @throws Exception
     */
    public function get(ConditionsDto $conditionsDto): Event
    {
        try {
            $event = $this->getEvent($conditionsDto);
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $event;
    }

    /**
     * @throws Exception
     */
    private function createEvent(EventDto $eventDto, ConditionsDto $conditionsDto): void
    {
        $createEventUseCase = new CreateEventUseCase($this->eventProvider);
        $createEventUseCase->create($eventDto, $conditionsDto);
    }

    /**
     * @throws Exception
     */
    private function getEvent(ConditionsDto $conditionsDto): ?Event
    {
        $getEventUseCase = new GetEventUseCase($this->eventProvider);
        return $getEventUseCase->get($conditionsDto);
    }
}
