<?php

declare(strict_types=1);

namespace Gesparo\HW\Domain\ValueObject;

class Name
{
    private readonly string $name;

    public function __construct(string $name)
    {
        $this->assertNotEmpty($name);
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->name;
    }

    private function assertNotEmpty(string $name): void
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Name cannot be empty');
        }
    }
}
