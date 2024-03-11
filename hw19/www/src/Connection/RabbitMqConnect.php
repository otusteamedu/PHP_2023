<?php

namespace Shabanov\Otusphp\Connection;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;

class RabbitMqConnect implements ConnectionInterface
{
    private AMQPStreamConnection $connect;
    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->connect = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
    }
    public function getClient(): AMQPChannel|AbstractChannel
    {
        return $this->connect->channel();
    }

    /**
     * @throws Exception
     */
    public function close(): void
    {
        $this->connect->close();
    }
}
