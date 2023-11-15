<?php

declare(strict_types=1);

namespace Gesparo\HW\Provider\AwesomeProvider;

use Gesparo\HW\Provider\SendingLogger;

class Manager
{
    private SendingLogger $logger;

    public function __construct(SendingLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @throws \JsonException
     */
    public function send(string $message, string $phone, int $delay): void
    {
        $this->logger->log([
            'provider' => 'awesome_provider',
            'message' => $message,
            'phone' => $phone,
            'delay' => $delay
        ]);
    }
}
