<?php

namespace app\components;

use Exception;
use PhpAmqpLib\Message\AMQPMessage;
use Yii;

class RabbitMqConsumer
{
    public function __construct(private RabbitMq $rabbitMq)
    {
    }

    /**
     * Чтение сообщений из RabbitMQ
     *
     * @param string $queueName
     * @throws Exception
     */
    public function consume(string $queueName): void
    {
        $channel = $this->rabbitMq->getChannel();
        $channel->queue_declare($queueName, false, true, false, false);

        $channel->basic_consume($queueName, '', false, true, false, false, [$this, 'callback']);

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

    public function callback(AMQPMessage $message): void
    {
        echo $message->body, "\n";
    }
}
