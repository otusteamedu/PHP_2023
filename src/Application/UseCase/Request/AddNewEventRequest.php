<?php

declare(strict_types=1);

namespace src\Application\UseCase\Request;

class AddNewEventRequest
{
    public function __construct(private string $event, private int $priority, private ?int $param1, private ?int $param2)
    {
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getParam1(): ?int
    {
        return $this->param1;
    }

    public function getParam2(): ?int
    {
        return $this->param2;
    }
}
