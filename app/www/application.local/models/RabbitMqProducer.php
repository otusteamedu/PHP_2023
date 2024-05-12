<?php

declare(strict_types=1);

namespace app\models;

use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqProducer
{
    public function __construct(private RabbitMq $rabbit)
    {
    }

    public function __invoke($message): void
    {
        $message = new AMQPMessage(json_encode($message));
        $this->rabbit->getChannel()->basic_publish($message, '', $this->rabbit->queueName);
        $this->rabbit->close();
    }
}

