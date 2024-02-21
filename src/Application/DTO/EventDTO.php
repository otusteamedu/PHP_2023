<?php
declare(strict_types=1);

namespace App\Application\DTO;

class EventDTO
{
    private ?int $priority;
    /* @var ConditionDTO[] */
    private ?array $conditions;
    /* @var OccasionDTO[] */
    private ?array $event;

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return ConditionDTO[]|null
     */
    public function getConditions(): ?array
    {
        return $this->conditions;
    }

    /**
     * @param ConditionDTO[]|null $conditions
     */
    public function setConditions(?array $conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * @return OccasionDTO[]|null
     */
    public function getEvent(): ?array
    {
        return $this->event;
    }

    /**
     * @param OccasionDTO[]|null $event
     */
    public function setEvent(?array $event): self
    {
        $this->event = $event;

        return $this;
    }
}
