<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Constants;
use App\Application\Dto\RequestDto;
use App\Entity\Request;
use App\Infrastructure\Factory\RabbitMqClientFactory;
use App\Repository\RequestRepository;
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
        private readonly SerializerInterface $serializer,
        private readonly RequestRepository $requestRepository,
        private readonly UsefulActionsDemoUseCase $actionsDemoUseCase
    ) {
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
            $channel->ack($message);
            /**
             * @var RequestDto $requestDto
             */
            $requestDto = $this->serializer->deserialize($message->content, RequestDto::class, 'json');
            $request = new Request();
            $request->setNumber($requestDto->getNumber());
            $request->setStatus(Constants::REQUEST_STATUS_PROCESSING);
            $this->requestRepository->save($request);
            $this->actionsDemoUseCase->doActions($request);
        }, Constants::QUEUE_NAME);

        $this->client->run();
    }
}
