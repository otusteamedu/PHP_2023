<?php

declare(strict_types=1);

namespace Vp\App\Application\RabbitMq;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Vp\App\Application\Dto\Output\ResultQueue;
use Vp\App\Application\RabbitMq\Contract\AmqpConnectionInterface;
use Vp\App\Application\RabbitMq\Contract\SenderInterface;

class RabbitSender implements SenderInterface
{
    private const PENDING_TIME = 2;

    private AMQPStreamConnection $connection;

    public function __construct(AmqpConnectionInterface $connection)
    {
        $this->connection = $connection->getConnection();
    }

    public function send(string $queueName, string $message): ResultQueue
    {
        $msg = new AMQPMessage(
            $message,
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        try {
            $channel = $this->connection->channel();
            $channel->confirm_select();
            $channel->queue_declare($queueName, false, true, false, false);
            $channel->basic_publish($msg, '', $queueName);
            $channel->wait_for_pending_acks(self::PENDING_TIME);
            $channel->close();
            $this->connection->close();
            return new ResultQueue(true, 'Job added to the queue');
        } catch (\Exception $e) {
            return new ResultQueue(false, 'An error occurred while adding a job to the queue, contact the application administrator');
        }
    }
}
