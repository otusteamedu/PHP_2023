<?php

namespace App\Domains\Order\Domain\ValueObjects;

class Phone
{
    private string $phone;

    public function __construct(string $phone)
    {
        $this->assertValidPhone($phone);
        $this->phone = $phone;
    }

    public function getValue(): string
    {
        return $this->phone;
    }

    private function assertValidPhone(string $phone): void
    {
        $strlen = mb_strlen($phone);
        if ($strlen !== 11) {
            throw new \InvalidArgumentException('Номер телефона не валиден');
        }
    }
}
