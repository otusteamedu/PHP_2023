<?php

declare(strict_types=1);

namespace Gesparo\HW\Domain\ValueObject;

class Condition
{
    private readonly string $name;
    private readonly int $value;

    public function __construct(string $name, int $value)
    {
        $this->assertNotEmpty($name);
        $this->assertValueIsNotNegative($value);
        $this->name = $name;
        $this->value = $value;
    }

    private function assertNotEmpty(string $name): void
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Condition name cannot be empty');
        }
    }

    private function assertValueIsNotNegative(int $value): void
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Value cannot be negative');
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
