<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Domain\ValueObject;

class EventTitle
{
    private string $eventTitle;

    public function __construct(string $eventTitle)
    {
        $this->assertValidEvent($eventTitle);
        $this->eventTitle = $eventTitle;
    }

    private function assertValidEvent(string $eventTitle): void
    {
        if (empty($eventTitle)) {
            throw new \Exception("Событие не может быть пустой строкой.");
        }
    }

    public function getValue(): string
    {
        return $this->eventTitle;
    }
}
