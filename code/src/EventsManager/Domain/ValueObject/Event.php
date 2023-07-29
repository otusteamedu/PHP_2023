<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Domain\ValueObject;

class Event
{
    private string $event;

    public function __construct(string $event)
    {
        $this->event = $event;
    }

    public function getValue(): string
    {
        return $this->event;
    }
}