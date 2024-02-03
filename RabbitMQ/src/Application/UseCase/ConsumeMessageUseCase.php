<?php

namespace App\Application\UseCase;

use App\Application\Dto\DateIntervalDto;
use App\Application\Service\TransactionsService;
use App\Infrastructure\Factory\RabbitMqClientFactory;
use Bunny\AbstractClient;
use Bunny\Channel;
use Bunny\Message;
use Exception;
use Symfony\Component\Serializer\SerializerInterface;

class ConsumeMessageUseCase
{
    private AbstractClient $client;

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly TransactionsService $transactionsService,
        private readonly SerializerInterface $serializer
    )
    {
        try {
            $this->client = RabbitMqClientFactory::create();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function run(): void
    {
        $channel = $this->client->channel();
        $channel->qos(prefetchCount: 1);
        $channel->consume(function (Message $message, Channel $channel): void {
            $dateIntervalDto = $this->serializer->deserialize($message->content, DateIntervalDto::class, 'json');
            $dateIntervalInfo = $this->transactionsService->getTransactionsInfo($dateIntervalDto);
            $channel->ack($message);
        }, 'events.analytics-service');

        $this->client->run();
    }
}
