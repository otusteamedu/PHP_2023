<?php

declare(strict_types=1);

namespace Gesparo\HW\Domain\ValueObject;

class Priority
{
    private readonly int $priority;

    public function __construct(int $priority)
    {
        $this->assertValueIsNotNegative($priority);
        $this->priority = $priority;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->priority;
    }

    private function assertValueIsNotNegative(int $priority): void
    {
        if ($priority < 0) {
            throw new \InvalidArgumentException('Priority cannot be negative');
        }
    }
}
