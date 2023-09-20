<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Services\Queue\StatementPublisher;

use Art\Code\Infrastructure\DTO\StatementSendDTO;
use Art\Code\Infrastructure\Interface\StatementPublisherInterface;
use Art\Code\Infrastructure\Rabbit\RabbitMQConnector;
use Art\Code\Infrastructure\Services\Queue\Interface\QueueInterface;
use JsonException;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class StatementPublisher implements QueueInterface, StatementPublisherInterface
{
    private AMQPChannel $channel;

    public function __construct(private readonly RabbitMQConnector $rabbitMQConnector)
    {
    }

    /**
     * @param array $data
     * @throws JsonException
     */
    public function send(array $data): void
    {
        $this->createChanel();
        $message = $this->createMessage($data);

        $this->channel->basic_publish($message, '', self::QUEUE_NAME_STATEMENT);
        $this->channel->close();
    }

    private function createChanel(): void
    {
        $connection =  $this->rabbitMQConnector->connection();
        $this->channel = $connection->channel();
        $this->channel->queue_declare(self::QUEUE_NAME_STATEMENT, false, false, false, false);
    }

    /**
     * @throws JsonException
     */
    private function createMessage(array $data): AMQPMessage
    {
        $dto  = new StatementSendDTO($data);
        return new AMQPMessage($dto->toAMQPMessage());
    }
}
