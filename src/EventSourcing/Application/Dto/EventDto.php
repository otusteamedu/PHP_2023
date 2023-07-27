<?php

declare(strict_types=1);

namespace Otus\App\EventSourcing\Application\Dto;

final readonly class EventDto
{
    /**
     * @param ConditionDto[] $conditions
     */
    public function __construct(
        private int $id,
        private string $name,
        private int $priority,
        private array $conditions,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return ConditionDto[]
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }
}
