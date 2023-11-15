<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\ValueObject;

class StoreElement
{
    private string $phone;
    private string $message;

    public function __construct(string $phone, string $message)
    {
        $this->phone = $phone;
        $this->message = $message;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
