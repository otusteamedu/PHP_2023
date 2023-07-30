<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Domain\ValueObject;

class Priority
{
    private int $priority;

    public function __construct(int $priority)
    {
        $this->assertValidPriority($priority);
        $this->priority = $priority;
    }

    private function assertValidPriority(int $priority): void
    {
        if ($priority < 0) {
            throw new \Exception("Приоритет не может быть отрицательным.");
        }
    }

    public function getValue(): int
    {
        return $this->priority;
    }
}
