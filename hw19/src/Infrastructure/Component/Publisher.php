<?php

declare(strict_types=1);

namespace App\Infrastructure\Component;

use App\Application\Component\PublisherInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class Publisher implements PublisherInterface
{
    public function __construct(
        private readonly string $exchange,
        private readonly AMQPStreamConnection $amqpConnection,
    ) {
    }

    public function __destruct()
    {
        $this->amqpConnection->close();
    }

    public function dispatch(object $command): void
    {
        $channel = $this->amqpConnection->channel();
        $channel->exchange_declare($this->exchange, AMQPExchangeType::FANOUT, false, false, false);
        $message = new AMQPMessage(serialize($command), ['content_type' => 'text/plain']);
        $channel->basic_publish($message, $this->exchange);
    }
}
