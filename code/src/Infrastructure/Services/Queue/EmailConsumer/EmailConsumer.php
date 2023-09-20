<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Services\Queue\EmailConsumer;

use Art\Code\Infrastructure\DTO\EmailReceivedDTO;
use Art\Code\Infrastructure\Rabbit\RabbitMQConnector;
use Art\Code\Infrastructure\Services\Queue\Interface\QueueInterface;
use PhpAmqpLib\Channel\AMQPChannel;

class EmailConsumer implements QueueInterface
{
    private AMQPChannel $channel;

    public function __construct(private readonly RabbitMQConnector $rabbitMQConnector)
    {
    }

    public function get(): void
    {
        $this->createChanel();
        $callback = function ($msg) {
            echo ' [x] Received email for send', $msg->body, "\n";
            $data = json_decode($msg->body, true);
            $dto = new EmailReceivedDTO($data);
            $this->sendMail($dto);
        };

        $this->channel->basic_consume(QueueInterface::QUEUE_NAME_EMAIL, '', false, true, false, false, $callback);

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }
    }

    private function createChanel(): void
    {
        $connection =  $this->rabbitMQConnector->connection();
        $this->channel = $connection->channel();
        $this->channel->queue_declare(QueueInterface::QUEUE_NAME_EMAIL, false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";
    }

    private function sendMail(EmailReceivedDTO $dto ): void
    {
        mail($dto->getTo(), $dto->getTitle(), $dto->getTitle());
    }
}