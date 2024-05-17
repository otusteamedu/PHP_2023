<?php

declare(strict_types=1);

namespace app\components;

use PhpAmqpLib\Message\AMQPMessage;
use Yii;

class RabbitMqProducer
{
    public function __construct(private RabbitMq $rabbitMq)
    {
    }

    public function sendMessage($queueName, $message): bool
    {
        try {
            $channel = $this->rabbitMq->getChannel();
            $channel->queue_declare($queueName, false, true, false, false);
            $message = new AMQPMessage(json_encode($message));
            $channel->basic_publish($message, '', $queueName);
            return true;
        } catch (\Exception $e) {
            Yii::error('Error sending message to RabbitMQ: ' . $e->getMessage());
            return false;
        }
    }
}
