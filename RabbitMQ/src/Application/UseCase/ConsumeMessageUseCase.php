<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Dto\TransactionsInfoDto;
use App\Application\Service\Exception\GetTransactionsDataException;
use App\Application\Service\Exception\SendMessageException;
use App\Application\Service\NotifyService;
use App\Application\Service\TransactionsService;
use App\Infrastructure\Constants;
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
        private readonly NotifyService $notifyService,
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
            /**
             * @var TransactionsInfoDto $transactionsInfoDto
             */
            $transactionsInfoDto = $this->serializer->deserialize($message->content, TransactionsInfoDto::class, 'json');

            try {
                $dateIntervalInfo = $this->transactionsService->getTransactionsInfo($transactionsInfoDto);
                $this->notifyService->sendMessage($transactionsInfoDto->getChatId(), $dateIntervalInfo);
            } catch (SendMessageException|GetTransactionsDataException $exception) {
                $channel->nack($message);
                throw new Exception($exception->getMessage());
            }

            $channel->ack($message);
        }, Constants::QUEUE_NAME);

        $this->client->run();
    }
}
