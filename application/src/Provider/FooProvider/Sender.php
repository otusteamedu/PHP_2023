<?php

declare(strict_types=1);

namespace Gesparo\HW\Provider\FooProvider;

use Gesparo\HW\Provider\SendingLogger;

class Sender
{
    private SendingLogger $logger;

    public function __construct(SendingLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @throws \JsonException
     */
    public function send(Message $message): void
    {
        $this->logger->log([
            'provider' => 'foo_provider',
            'message' => $message->getMessage(),
            'phone' => $message->getPhone(),
            'at_time' => $message->getAtTime()
        ]);
    }
}
