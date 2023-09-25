<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Services\Queue\RequestConsumer;

use Art\Code\Domain\Entity\RequestStatus;
use Art\Code\Infrastructure\Broker\Rabbit\RabbitMQConnector;
use Art\Code\Infrastructure\DTO\RequestReceivedDTO;
use Art\Code\Infrastructure\Repository\RequestRepository;
use Art\Code\Infrastructure\Services\Queue\EmailPublisher\EmailPublisher;
use Art\Code\Infrastructure\Services\Queue\Interface\QueueInterface;
use Art\Code\Infrastructure\Services\Request\RequestService;
use JsonException;
use PhpAmqpLib\Channel\AMQPChannel;

class RequestConsumer implements QueueInterface
{
    private AMQPChannel $channel;

    public function __construct(
        private readonly RabbitMQConnector $rabbitMQConnector,
        private readonly RequestService    $requestService,
        private readonly EmailPublisher    $emailPublisher,
        private readonly RequestRepository $requestRepository
    )
    {
    }

    public function get(): void
    {
        $this->createChanel();

        $callback = function ($msg) {

            echo ' [x] Received request with data', $msg->body, "\n";

            $data = json_decode($msg->body, true);
            $dto = new RequestReceivedDTO($data);

            $this->requestRepository->updateStatus(RequestStatus::REQUEST_STATUS_IN_PROCESS, $data['request_id']);

            //обработка и получение результата
            if ($this->makeRequest($dto)) {
                echo " Выписка сформирована. Данные отправлены.";
                $this->requestRepository->updateStatus(RequestStatus::REQUEST_STATUS_COMPLETED, $data['request_id']);
            }


        };
        $this->channel->basic_consume(QueueInterface::QUEUE_NAME_REQUEST, '', false, true, false, false, $callback);
        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

    }

    private function createChanel(): void
    {
        $connection = $this->rabbitMQConnector->connection();
        $this->channel = $connection->channel();

        $this->channel->queue_declare(QueueInterface::QUEUE_NAME_REQUEST, false, false, false, false);
        echo " [*] Waiting for messages. To exit press CTRL+C\n";
    }

    /**
     * The method generates statement data and sends the finished statement
     * @throws JsonException
     */
    private function makeRequest(RequestReceivedDTO $dto): bool
    {
        return $this->requestService->createRequest($dto, $this->emailPublisher);
    }
}