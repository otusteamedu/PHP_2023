<?php

declare(strict_types=1);

namespace Gesparo\Homework;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitConnectionFactory
{
    public function __construct(private readonly EnvManager $envManager)
    {
    }

    public function create(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            'queue',
            5672,
            $this->envManager->getRabbitMqUser(),
            $this->envManager->getRabbitMqPassword()
        );
    }
}