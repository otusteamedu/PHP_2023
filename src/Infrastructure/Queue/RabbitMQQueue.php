<?php

declare(strict_types=1);

namespace User\Php2023\Infrastructure\Queue;

use Exception;
use JsonException;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use User\Php2023\Domain\Interfaces\QueueConsumeHandlerInterface;
use User\Php2023\Infrastructure\Queue\RabbitMQ\Connection;

class RabbitMQQueue implements QueueInterface
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    /**
     * @throws Exception
     */
    public function __construct(private readonly string $queueName)
    {
        $rmqConnection = new Connection();
        $connectionParams = $rmqConnection->connect();
        $this->connection = new AMQPStreamConnection(
            $connectionParams->getHost(),
            $connectionParams->getPort(),
            $connectionParams->getUsername(),
            $connectionParams->getPassword()
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($queueName);
    }

    /**
     * @throws JsonException
     */
    public function push(array $data): void
    {
        $msg = new AMQPMessage(json_encode($data, JSON_THROW_ON_ERROR),
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $this->channel->basic_publish($msg, '', $this->queueName);
    }

    /**
     * @throws JsonException
     */
    public function get(): array
    {
        $message = $this->channel->basic_get($this->queueName);
        if ($message) {
            $this->channel->basic_ack($message->delivery_info['delivery_tag']);
            return json_decode($message->body, true, 512, JSON_THROW_ON_ERROR);
        }
        return [];
    }

    /**
     * @throws Exception
     */
    public function isEmpty(): bool
    {
        throw new \RuntimeException("Method not implemented");
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function consumeWithHandler(QueueConsumeHandlerInterface $handler): void
    {
        $callback = function ($msg) use ($handler) {
            $handler->handle($msg->body);
        };
        $this->channel->basic_consume($this->queueName, '', false, true, false, false, $callback);
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}
