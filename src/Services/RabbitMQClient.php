<?php

namespace Api\Daniel\Services;

use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQClient implements MessageQueueClientInterface
{
    private AbstractChannel|AMQPChannel $channel;
    private AMQPStreamConnection $connection;
    private $callback;

    public function __construct($host, $port, $user, $password)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->channel = $this->connection->channel();
    }

    public function declareQueue($queueName): void
    {
        $this->channel->queue_declare($queueName, false, true, false, false);
    }

    public function publish($queueName, $data, $correlationId): void
    {
        $msg = new AMQPMessage($data, [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            'correlation_id' => $correlationId
        ]);
        $this->channel->basic_publish($msg, '', $queueName);
    }

    public function setCallback($callback): void
    {
        $this->callback = $callback;
    }

    public function startConsuming($queueName): void
    {
        if (!is_callable($this->callback)) {
            throw new \InvalidArgumentException("Callback must be callable.");
        }

        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume($queueName, '', false, false, false, false, $this->callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
