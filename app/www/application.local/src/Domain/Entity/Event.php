<?php

declare(strict_types=1);

namespace AYamaliev\hw12\Domain\Entity;

class Event
{
    public function __construct(private int $priority, private string $event, private ?string $param1, private ?string $param2)
    {
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @return string|null
     */
    public function getParam1(): ?string
    {
        return $this->param1;
    }

    /**
     * @return string|null
     */
    public function getParam2(): ?string
    {
        return $this->param2;
    }
}
