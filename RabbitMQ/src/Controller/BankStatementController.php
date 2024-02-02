<?php

namespace App\Controller;

use App\Infrastructure\Factory\RabbitMqClientFactory;
use Bunny\AbstractClient;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BankStatementController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function __construct(private AbstractClient $client)
    {
        try {
            $this->client = RabbitMqClientFactory::create();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    #[Route('/generate', name: 'app_generate', methods: ['GET'])]
    public function generate(Request $request): JsonResponse
    {
        $dateTo = new DateTime($request->get('dateTo'));
        $dateFrom = new DateTime($request->get('dateFrom'));

        $channel = $this->client->channel();
        $channel->publish('{"paymentId": 1}', exchange: 'events', routingKey: 'payment_succeeded');

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/BankStatementController.php',
        ]);
    }
}
