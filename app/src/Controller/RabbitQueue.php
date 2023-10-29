<?php

namespace Nikitaglobal\Controller;

use Nikitaglobal\Model\RabbitQueue as QueuesModel;

class RabbitQueue
{
    /**
     * @var AMQPStreamConnection
     */
    public $connection;
    /**
     * @var AMQPChannel
     */
    public $channel;
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection($_ENV['RABBITMQ_HOST'], $_ENV['RABBITMQ_PORT'], $_ENV['RABBITMQ_USER'], $_ENV['RABBITMQ_PASSWORD']);
        $this->channel = $this->connection->channel();
    }

    public function add($quene_name, $message)
    {
        $message = QueuesModel($this->connection, $this->channel, json_encode($message));
        return true;
    }
}
