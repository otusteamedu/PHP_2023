<?php

declare(strict_types=1);

namespace User\Php2023\Infrastructure\Queue\RabbitMQ;

class Connection
{
    public function connect(): RabbitMQConnection
    {
        return new RabbitMQConnection(
            $_ENV['RABBITMQ_HOST'],
            $_ENV['RABBITMQ_PORT'],
            $_ENV['RABBITMQ_USER'],
            $_ENV['RABBITMQ_PASSWORD'],
        );
    }
}
