<?php

declare(strict_types=1);

namespace Gesparo\HW\Factory;

use Gesparo\HW\ValueObject\Message;
use Gesparo\HW\ValueObject\Phone;
use Gesparo\HW\ValueObject\SMS;

class SMSMessageFactory
{
    public function create(string $phone, string $message): SMS
    {
        return new SMS(new Phone($phone), new Message($message));
    }
}
