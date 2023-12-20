<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Factory;

use Gesparo\Homework\Application\EnvManager;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitConnectionFactory
{
    public function __construct(private readonly EnvManager $envManager)
    {
    }

    /**
     * @throws \Exception
     */
    public function create(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            'queue',
            $this->envManager->getRabbitMqPort(),
            $this->envManager->getRabbitMqUser(),
            $this->envManager->getRabbitMqPassword()
        );
    }
}
