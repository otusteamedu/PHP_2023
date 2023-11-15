<?php

declare(strict_types=1);

namespace Gesparo\HW\Provider\FooProvider;

use Gesparo\HW\Provider\SendingLogger;

class FooClient
{
    private Sender $sender;

    public function __construct(SendingLogger $logger)
    {
        $this->sender = new Sender($logger);
    }

    public function getMessage(string $message, string $phone, string $atTime): Message
    {
        return new Message($this->sender, $message, $phone, $atTime);
    }
}
