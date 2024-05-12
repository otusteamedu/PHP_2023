<?php

declare(strict_types=1);

namespace app\models;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMq
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    /**
     * @throws Exception
     */
    public function __construct(public string $queueName)
    {
        $this->connection = new AMQPStreamConnection(
            $_ENV['RABBITMQ_HOST'],
            5672,
            $_ENV['RABBITMQ_USER'],
            $_ENV['RABBITMQ_PASS']
        );
        $this->channel = $this->connection->channel();
        $this->queueDeclare();
    }

    private function queueDeclare(): void
    {
        $this->channel->queue_declare($this->queueName, false, true, false, false);
    }

    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    /**
     * @throws Exception
     */
    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
