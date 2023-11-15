<?php

declare(strict_types=1);

namespace Gesparo\HW\ValueObject;

class SMS
{
    private Message $message;
    private Phone $phone;

    public function __construct(Phone $phone, Message $message)
    {
        $this->message = $message;
        $this->phone = $phone;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }
}
