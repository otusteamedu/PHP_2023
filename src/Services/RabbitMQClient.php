<?php

namespace Api\Daniel\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQClient
{
    private $channel;
    private $connection;

    public function __construct($host, $port, $user, $password)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->channel = $this->connection->channel();
    }

    public function declareQueue($queueName)
    {
        $this->channel->queue_declare($queueName, false, true, false, false);
    }

    public function publish($queueName, $data, $correlationId)
    {
        $msg = new AMQPMessage($data, [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            'correlation_id' => $correlationId
        ]);
        $this->channel->basic_publish($msg, '', $queueName);
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}