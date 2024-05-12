<?php

declare(strict_types=1);

namespace app\models;

use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqConsumer
{
    public function __construct(private RabbitMq $rabbit)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(): void
    {
        $channel = $this->rabbit->getChannel();
        $channel->basic_consume($this->rabbit->queueName, '', false, true, false, false, [$this, 'callback']);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $this->rabbit->close();
    }

    public function callback(AMQPMessage $message): void
    {
        echo $message->body, "\n";
    }
}

