<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Services\Queue\StatementConsumer;

use Art\Code\Infrastructure\DTO\StatementReceivedDTO;
use Art\Code\Infrastructure\Rabbit\RabbitMQConnector;
use Art\Code\Infrastructure\Services\Queue\EmailPublisher\EmailPublisher;
use Art\Code\Infrastructure\Services\Queue\Interface\QueueInterface;
use Art\Code\Infrastructure\Services\Statement\StatementService;
use JsonException;
use PhpAmqpLib\Channel\AMQPChannel;

class StatementConsumer implements QueueInterface
{
    private AMQPChannel $channel;

    public function __construct(
        private readonly RabbitMQConnector $rabbitMQConnector,
        private readonly StatementService  $statementService,
        private readonly EmailPublisher    $emailPublisher
    )
    {
    }

    public function get(): void
    {
        $this->createChanel();

        $callback = function ($msg) {
            $data = json_decode($msg->body, true);
            $dto = new StatementReceivedDTO($data);

            echo ' [x] Received request with data', $msg->body, "\n";

            // обработка и получение результата
            if ($this->getStatement($dto))
                echo " Выписка сформирована. Данные отправлены.";
        };

        $this->channel->basic_consume(QueueInterface::QUEUE_NAME_STATEMENT, '', false, true, false, false, $callback);
        while ($this->channel->is_open()) {
            $this->channel->wait();
        }
    }

    private function createChanel(): void
    {
        $connection = $this->rabbitMQConnector->connection();
        $this->channel = $connection->channel();
        $this->channel->queue_declare(QueueInterface::QUEUE_NAME_STATEMENT, false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";
    }

    /**
     * The method generates statement data and sends the finished statement
     *
     * @throws JsonException
     */
    private function getStatement(StatementReceivedDTO $dto): bool
    {
        return $this->statementService->createStatement($dto, $this->emailPublisher);
    }
}