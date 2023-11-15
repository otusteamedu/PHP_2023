<?php

declare(strict_types=1);

namespace Gesparo\HW\ValueObject;

class Phone
{
    private string $phone;

    public function __construct(string $phone)
    {
        $this->assertNotEmpty($phone);
        $this->assertValidPhone($phone);

        $this->phone = $phone;
    }

    private function assertNotEmpty(string $phone): void
    {
        if (empty($phone)) {
            throw new \InvalidArgumentException('Phone can not be empty');
        }
    }

    private function assertValidPhone(string $phone): void
    {
        if (!preg_match('/^\+?[\d-]+$/', $phone)) {
            throw new \InvalidArgumentException('Phone is not valid');
        }
    }

    public function getValue(): string
    {
        return $this->phone;
    }
}
