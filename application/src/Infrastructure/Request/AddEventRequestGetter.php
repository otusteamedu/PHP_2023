<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Request;

use Gesparo\HW\Application\UseCase\Request\AddEventsRequest;
use Gesparo\HW\Application\UseCase\Request\ConditionDTO;
use Gesparo\HW\Application\UseCase\Request\EventDTO;
use Symfony\Component\HttpFoundation\Request;

class AddEventRequestGetter
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws \JsonException
     */
    public function getRequest(): AddEventsRequest
    {
        $decodedEvents = json_decode($this->request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($decodedEvents)) {
            throw new \InvalidArgumentException('you should pass array of events');
        }

        $events = [];

        foreach ($decodedEvents as $event) {
            $conditions = [];

            foreach ($event['conditions'] ?? [] as $conditionName => $conditionValue) {
                $conditions[] = new ConditionDTO($conditionName, $conditionValue);
            }

            $events[] = new EventDTO($event['event'] ?? '', $event['priority'] ?? 0, $conditions);
        }

        return new AddEventsRequest($events);
    }
}
