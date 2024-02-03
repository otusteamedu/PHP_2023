<?php

namespace App\Controller;

use App\Application\Dto\DateIntervalDto;
use App\Application\UseCase\ConsumeMessageUseCase;
use App\Infrastructure\Factory\RabbitMqClientFactory;
use App\Repository\ExpenseRepository;
use App\Repository\IncomeRepository;
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
        private readonly ExpenseRepository $expensiveRepository,
        private readonly IncomeRepository $incomeRepository,
        private readonly SerializerInterface $serializer,
        private readonly ConsumeMessageUseCase $consumeMessageUseCase
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
    #[Route('/generate', name: 'app_generate', methods: ['GET'])]
    public function generate(Request $request): JsonResponse
    {
        $dateTo = new DateTime($request->get('dateTo'));
        $dateFrom = new DateTime($request->get('dateFrom'));
//        $dateTo = $request->get('dateTo');
//        $dateFrom = $request->get('dateFrom');
        $dateIntervalDto = new DateIntervalDto($dateFrom, $dateTo);

        $serializedDto = $this->serializer->serialize($dateIntervalDto, 'json');
        $channel = $this->client->channel();
        $channel->publish($serializedDto, exchange: 'events', routingKey: 'payment_succeeded');
        //-----вот здесь зависает
        $this->consumeMessageUseCase->run();

//        $statement = '';
//        $incomes = $this->incomeRepository->findByBetweenDates($dateFrom, $dateTo);
//        foreach ($incomes as $income) {
//            $statement .= sprintf(
//                    '%s: +%s %s',
//                    $income->getDate()->format('d.m.Y H:i:s'),
//                    $income->getAmount(),
//                    $income->getCurrency(),
//                ) . PHP_EOL;
//        }
//
//        $expenses = $this->expensiveRepository->findByBetweenDates($dateFrom, $dateTo);
//        foreach ($expenses as $expense) {
//            $statement .= sprintf(
//                    '%s: %s %s',
//                    $expense->getDate()->format('d.m.Y H:i:s'),
//                    $expense->getAmount(),
//                    $expense->getCurrency(),
//                ) . PHP_EOL;
//        }

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'status' => Response::HTTP_OK
        ]);
    }
}
