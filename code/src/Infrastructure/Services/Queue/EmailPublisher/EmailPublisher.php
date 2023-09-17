<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Services\Queue\EmailPublisher;

use Art\Code\Infrastructure\DTO\EmailSendDTO;
use Art\Code\Infrastructure\Rabbit\RabbitMQConnector;
use Art\Code\Infrastructure\Services\Queue\Interface\QueueInterface;
use JsonException;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class EmailPublisher implements QueueInterface
{
    private AMQPChannel $channel;

    public function __construct(private readonly RabbitMQConnector $rabbitMQConnector)
    {
    }

    /**
     * @throws JsonException
     */
    public function send(array $data): void
    {
        $this->createChanel();
        $message = $this->createMessage($data);
        $this->channel->basic_publish($message, '', self::QUEUE_NAME_EMAIL);
        $this->channel->close();
    }

    private function createChanel(): void
    {
        $connection =  $this->rabbitMQConnector->connection();
        $this->channel = $connection->channel();
        $this->channel->queue_declare(self::QUEUE_NAME_EMAIL, false, false, false, false);
    }

    /**
     * @throws JsonException
     */
    private function createMessage(array $data): AMQPMessage
    {
        $dto  = new EmailSendDTO($data);
        return new AMQPMessage($dto->toAMQPMessage());
    }
}