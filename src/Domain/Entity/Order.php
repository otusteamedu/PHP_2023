<?php

declare(strict_types=1);

namespace src\Domain\Entity;

use src\Domain\Builder\OrderBuilder;

class Order
{
    private string $address;
    private string $phone;
    private string $email;

    public function __construct(OrderBuilder $orderBuilder)
    {
        $this->address = $orderBuilder->getAddress();
        $this->phone = $orderBuilder->getPhone();
        $this->email = $orderBuilder->getEmail();
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
