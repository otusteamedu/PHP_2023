<?php

namespace App\Domains\Order\Domain\ValueObjects;

class Address
{
    private string $city;
    private string $street;
    private string $house;

    public function __construct(
        string $city,
        string $street,
        string $house,
    )
    {
        $this->assertValidCity($city);
        $this->assertValidStreet($street);
        $this->assertValidHouse($house);
        $this->city = $city;
        $this->street = $street;
        $this->house = $house;
    }

    public function getFullAddress(): int
    {
        return  "{$this->city} {$this->street} {$this->house}";
    }

    private function assertValidCity(string $city): void
    {
    }

    private function assertValidStreet(string $street): void
    {
    }

    private function assertValidHouse(string $house): void
    {
    }
}
