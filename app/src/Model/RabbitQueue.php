<?php

namespace Nikitaglobal\Model;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitQueue
{
    public static function add($channel, $connection, $queueName, $message)
    {

        $channel->queue_declare($queueName, false, false, false, false);
        $channel->basic_publish($message);
        $channel->close();
        $connection->close();
        return true;
    }
}
