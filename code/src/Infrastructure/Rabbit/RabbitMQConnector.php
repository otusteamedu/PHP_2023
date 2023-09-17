<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Rabbit;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConnector
{
    private AMQPStreamConnection $connection;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->connection = $this->create();
    }

    public function connection() : AMQPStreamConnection
    {
        return $this->connection;
    }

    public function channel(?int $channel_id = null): \PhpAmqpLib\Channel\AbstractChannel|\PhpAmqpLib\Channel\AMQPChannel
    {
        return $this->connection->channel($channel_id);
    }

    /**
     * @throws Exception
     */
    private function create() : AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            getenv('RABBITMQ_HOST'),
            getenv('RABBITMQ_PORT'),
            getenv('RABBITMQ_DEFAULT_USER'),
            getenv('RABBITMQ_DEFAULT_PASS'),
        );

    }
}