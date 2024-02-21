<?php
declare(strict_types=1);

namespace App\Application\DTO\Builder;

use App\Application\DTO\ConditionDTO;
use App\Application\DTO\EventDTO;
use App\Application\DTO\OccasionDTO;
use App\Application\Helper\BuildHelper;
use App\Domain\Entity\Event;
use App\Domain\ValueObject\Condition;
use App\Domain\ValueObject\Occasion;

readonly class EventDTOBuilder
{
    public function __construct(private BuildHelper $buildHelper)
    {
    }

    public function build(int $priority, string $conditions, string $events): EventDTO
    {
        $eventsDTO = [];
        $events    = $this->buildHelper->getHashArrayFromString($events);

        foreach ($events as $name => $value) {
            $eventsDTO[] = new OccasionDTO($name, $value);
        }

        $conditionsDTO = [];
        $conditions    = $this->buildHelper->getHashArrayFromString($conditions);

        foreach ($conditions as $operandLeft => $operandRight) {
            $conditionsDTO[] = new ConditionDTO($operandLeft, $operandRight);
        }

        return (new EventDTO())
            ->setPriority($priority)
            ->setConditions($conditionsDTO)
            ->setEvent($eventsDTO);
    }

    public function buildFromEntity(Event $event): EventDTO
    {
        $events     = array_map(
            static fn (Occasion $event): OccasionDTO => new OccasionDTO($event->getName(), $event->getValue()),
            $event->getEvent()
        );
        $conditions = array_map(
            static fn (Condition $condition): ConditionDTO => new ConditionDTO(
                $condition->getOperandLeft(), $condition->getOperandRight()
            ),
            $event->getConditions()
        );

        return (new EventDTO())
            ->setPriority($event->getPriority())
            ->setEvent($events)
            ->setConditions($conditions);
    }
}
