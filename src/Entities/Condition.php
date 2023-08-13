<?php

declare(strict_types=1);

namespace Ro\Php2023\Entities;

class Condition implements ConditionInterface
{
    public function __construct(
        private readonly string $conditionName,
        private readonly int|string $conditionValue,
    ) {
    }

    public function getName(): string
    {
        return $this->conditionName;
    }

    public function getValue(): int|string
    {
        return $this->conditionValue;
    }
}