<?php

namespace App\Controller;

use App\Application\Dto\TransactionsInfoDto;
use App\Entity\Exception\ChatIdNotValidException;
use App\Entity\ValueObject\ChatId;
use App\Infrastructure\Factory\RabbitMqClientFactory;
use Bunny\AbstractClient;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BankStatementController extends AbstractController
{
    /**
     * @throws Exception
     */
    private AbstractClient $client;

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
        try {
            $this->client = RabbitMqClientFactory::create();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    #[Route('/generate', name: 'app_generate', methods: ['POST'])]
    public function generate(Request $request): JsonResponse
    {
        $dateTo = new DateTime($request->toArray()['dateTo']);
        $dateFrom = new DateTime($request->toArray()['dateFrom']);

        try {
            $chatId = new ChatId($request->toArray()['chatId']);
        } catch (ChatIdNotValidException $exception) {
            throw new Exception($exception->getMessage());
        }

        $dateIntervalDto = new TransactionsInfoDto($dateFrom, $dateTo, $chatId->getValue());

        $serializedDto = $this->serializer->serialize($dateIntervalDto, 'json');
        $channel = $this->client->channel();
        $channel->publish($serializedDto, exchange: 'events', routingKey: 'payment_succeeded');

        return $this->json([
            'message' => 'Your request has been queued. We will notify you when it is done.',
            'status' => Response::HTTP_OK
        ]);
    }
}
