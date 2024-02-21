<?php
declare(strict_types=1);

namespace App\Application\EntityBuilder;

use App\Application\DTO\ConditionDTO;
use App\Application\DTO\EventDTO;
use App\Application\DTO\OccasionDTO;
use App\Domain\Entity\Event;
use App\Domain\Exception\InvalidArgumentException;
use App\Domain\ValueObject\Condition;
use App\Domain\ValueObject\Occasion;

class EventBuilder
{
    /**
     * @throws InvalidArgumentException
     */
    public function buildFromEventDTO(EventDTO $eventDTO): Event
    {
        $events     = array_map(
            static fn (OccasionDTO $event): Occasion => new Occasion($event->getName(), $event->getValue()),
            $eventDTO->getEvent()
        );
        $conditions = array_map(
            static fn (ConditionDTO $condition): Condition => new Condition(
                $condition->getOperandLeft(), $condition->getOperandRight()
            ),
            $eventDTO->getConditions()
        );

        return new Event($eventDTO->getPriority(), $conditions, $events);
    }
}
