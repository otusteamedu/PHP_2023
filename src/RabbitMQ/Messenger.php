<?php

declare(strict_types=1);

namespace App\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

final readonly class Messenger
{
    public function __construct(
        private AMQPStreamConnection $connection,
        private string $exchange,
        private string $queue,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function publish(string $messageBody): void
    {
        $channel = $this->createChannel();

        $message = new AMQPMessage($messageBody, [
            'content_type' => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        $channel->basic_publish($message, $this->exchange);

        $this->shutdown($channel, $this->connection);
    }

    public function consume(callable|null $processMessage = null): void
    {
        $ackProcessMessage = function (AMQPMessage $message) use ($processMessage): void {
            if ($processMessage !== null) {
                $processMessage($message->getBody());
            }

            $message->ack();

            if ($message->body === 'quit') {
                $message->getChannel()->basic_cancel($message->getConsumerTag());
            }
        };

        $channel = $this->createChannel();

        $channel->basic_consume(
            queue: $this->queue,
            consumer_tag: 'consumer',
            callback: $ackProcessMessage(...)
        );

        register_shutdown_function($this->shutdown(...), $channel, $this->connection);

        while ($channel->is_consuming()) {
            $channel->wait(null, true);
            // do something else
            usleep(300000);
        }
    }

    private function createChannel(): AMQPChannel
    {
        $channel = $this->connection->channel();

        $channel->queue_declare($this->queue, false, true, false, false);
        $channel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, true, false);

        $channel->queue_bind($this->queue, $this->exchange);

        return $channel;
    }

    /**
     * @throws \Exception
     */
    private function shutdown(AMQPChannel $channel, AbstractConnection $connection): void
    {
        $channel->close();
        $connection->close();
    }
}