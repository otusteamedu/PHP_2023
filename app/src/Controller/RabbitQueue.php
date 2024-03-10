<?php

namespace Nikitaglobal\Controller;

use Nikitaglobal\Model\RabbitQueue as QueuesModel;
use PhpAmqpLib\Connection\AMQPStreamConnection as AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage as AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel as AMQPChannel;

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

    public function add($queue_name, $message)
    {
        $message = QueuesModel::add($this->channel, $this->channel, $queue_name, new AMQPMessage(json_encode($message)));
        return true;
    }
}
