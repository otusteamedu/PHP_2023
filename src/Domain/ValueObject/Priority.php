<?php

namespace App\Domain\ValueObject;

class Priority
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException("Priority must be a non-negative integer.");
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}