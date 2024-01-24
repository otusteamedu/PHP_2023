<?php

declare(strict_types=1);

namespace src\Application\UseCase\Response;

class GetByParametersResponse
{
    private int $priority;
    private ?int $param1;
    private ?int $param2;
    private string $event;

    public function __construct(int $priority, ?int $param1, ?int $param2, string $event)
    {
        $this->priority = $priority;
        $this->param1 = $param1;
        $this->param2 = $param2;
        $this->event = $event;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getParam1(): int
    {
        return $this->param1;
    }

    public function getParam2(): int
    {
        return $this->param2;
    }

    public function getEvent(): string
    {
        return $this->event;
    }
}
