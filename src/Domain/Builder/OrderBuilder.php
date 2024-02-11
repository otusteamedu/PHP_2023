<?php

declare(strict_types=1);

namespace src\Domain\Builder;

use src\Domain\Entity\Order;

class OrderBuilder
{
    private string $address;
    private string $phone;
    private string $email;

    public function setAddress(string $address): OrderBuilder
    {
        $this->address = $address;
        return $this;
    }

    public function setPhone(string $phone): OrderBuilder
    {
        $this->phone = $phone;
        return $this;
    }

    public function setEmail(string $email): OrderBuilder
    {
        $this->email = $email;
        return $this;
    }

    public function build(): Order
    {
        return new Order($this);
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
