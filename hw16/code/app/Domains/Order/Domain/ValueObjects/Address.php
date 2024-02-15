<?php

namespace App\Domains\Order\Domain\ValueObjects;

class Address
{
    private string $address;

    public function __construct(string $address)
    {
        $this->assertValidAddress($address);
        $this->address = $address;
    }

    public function getValue(): string
    {
        return $this->address;
    }

    private function assertValidAddress(string $address): void
    {
        $strlen = mb_strlen($address);
        if ($strlen < 10 || $strlen > 500) {
            throw new \InvalidArgumentException('Адрес не валиден');
        }
    }
}
