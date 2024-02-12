<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\Constants;
use App\Application\Dto\RequestDto;
use App\Infrastructure\Factory\RabbitMqClientFactory;
use App\Repository\RequestRepository;
use Bunny\AbstractClient;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

#[Route('api/v1/request', name: 'demo_api')]
class ApiController extends AbstractController
{
    private AbstractClient $client;

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly RequestRepository $requestRepository
    ) {
        try {
            $this->client = RabbitMqClientFactory::create();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    #[Route('/post', name: 'app_demo_api_post', methods: ['POST'])]
    public function index(): JsonResponse
    {
        $requestDto = new RequestDto(Uuid::v1()->toBase32());
        $serializedDto = $this->serializer->serialize($requestDto, 'json');
        $channel = $this->client->channel();
        $channel->publish($serializedDto, exchange: Constants::EXCHANGE_NAME, routingKey: Constants::ROUTING_KEY);

        return $this->json([
            'status' => Response::HTTP_OK,
            'RequestNumber' => $requestDto->getNumber(),
        ]);
    }

    #[Route('/get/{requestNumber}', name: 'app_demo_api_get', methods: ['GET'])]
    public function getStatus(string $requestNumber): JsonResponse
    {
        $request = $this->requestRepository->findOneBy(['number' => $requestNumber]);

        return $this->json([
            'status' => Response::HTTP_OK,
            'requestNumber' => $request->getNumber(),
            'RequestStatus' => $request->getStatus(),
        ]);
    }
}
