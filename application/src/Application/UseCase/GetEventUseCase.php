<?php

declare(strict_types=1);

namespace Gesparo\HW\Application\UseCase;

use Gesparo\HW\Application\UseCase\Request\EventDTO;
use Gesparo\HW\Application\UseCase\Request\GetEventRequest;
use Gesparo\HW\Application\UseCase\Response\GetEventResponse;
use Gesparo\HW\Domain\Entity\Event;
use Gesparo\HW\Domain\List\GetConditionList;
use Gesparo\HW\Domain\Repository\GetEventInterface;
use Gesparo\HW\Domain\ValueObject\Condition;

class GetEventUseCase
{
    private GetEventInterface $storage;

    public function __construct(GetEventInterface $storage)
    {
        $this->storage = $storage;
    }

    public function get(GetEventRequest $request): GetEventResponse
    {
        $event = $this->storage->get($this->getConditionList($request));

        return $this->getResponseDTO($event);
    }

    private function getConditionList(GetEventRequest $request): GetConditionList
    {
        $conditions = [];

        foreach ($request->conditions as $condition) {
            $conditions[] = new Condition($condition->name, $condition->value);
        }

        return new GetConditionList($conditions);
    }

    private function getResponseDTO(?Event $event): GetEventResponse
    {
        if ($event === null) {
            return new GetEventResponse(null);
        }

        $conditions = [];

        foreach ($event->getConditions() as $condition) {
            $conditions[$condition->getName()] = $condition->getValue();
        }

        return new GetEventResponse(new EventDTO(
            $event->getName()->getValue(),
            $event->getPriority()->getValue(),
            $conditions
        ));
    }
}
