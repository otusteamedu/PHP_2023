<?php

declare(strict_types=1);

namespace src\Application\UseCase\Request;

class CreateOrderRequest
{
    public function __construct(
        private string $address,
        private string $phone,
        private string $email,
    )
    {
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
