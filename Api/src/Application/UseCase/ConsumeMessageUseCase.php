<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Contracts\NotifyServiceInterface;
use App\Application\Dto\TransactionsInfoDto;
use App\Application\Service\Exception\GetTransactionsDataException;
use App\Application\Service\Exception\SendMessageException;
use App\Application\Service\TransactionsService;
use App\Infrastructure\Constants;
use App\Infrastructure\Factory\RabbitMqClientFactory;
use Bunny\AbstractClient;
use Bunny\Channel;
use Bunny\Message;
use Exception;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ConsumeMessageUseCase
{
    private AbstractClient $client;

    /**
     * @throws Exception
     */
    public function __construct()
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
            var_dump($message->content);
            $channel->ack($message);
        }, Constants::QUEUE_NAME);

        $this->client->run();
    }
}
