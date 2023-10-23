<?php

namespace Nikitaglobal\Model;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Queues
{
    public static function add($startDate, $endDate)
    {
        $connection = new AMQPStreamConnection($_ENV['RABBITMQ_HOST'], $_ENV['RABBITMQ_PORT'], $_ENV['RABBITMQ_USER'], $_ENV['RABBITMQ_PASSWORD']);
        $channel = $connection->channel();

        $queueName = 'banking_queue';
        $channel->queue_declare($queueName, false, false, false, false);
        $message = new AMQPMessage(json_encode([
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]));
        $channel->basic_publish($message);
        $channel->close();
        $connection->close();
        return true;
    }
}
