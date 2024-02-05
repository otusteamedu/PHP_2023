<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\Service\Exception\MissedParamException;
use App\Application\Service\RequestParseService;
use App\Entity\Exception\ChatIdNotValidException;
use App\Infrastructure\Constants;
use App\Infrastructure\Factory\RabbitMqClientFactory;
use Bunny\AbstractClient;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/v1', name: 'bank_transactions_api')]
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
        private readonly RequestParseService $requestParseService,
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
        try {
            $dateIntervalDto = $this->requestParseService->getTransactionInfoByRequest($request);
            $serializedDto = $this->serializer->serialize($dateIntervalDto, 'json');
            $channel = $this->client->channel();
            $channel->publish($serializedDto, exchange: Constants::EXCHANGE_NAME, routingKey: Constants::ROUTING_KEY);

            return $this->json([
                'message' => 'Your request has been queued. We will notify you when it is done.',
                'status' => Response::HTTP_OK
            ]);
        } catch (MissedParamException|ChatIdNotValidException $exception) {
            return $this->json([
                'message' => $exception->getMessage(),
                'status' => Response::HTTP_BAD_REQUEST
            ]);
        }
    }
}
