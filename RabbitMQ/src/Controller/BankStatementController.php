<?php

namespace App\Controller;

use App\Infrastructure\Factory\RabbitMqClientFactory;
use App\Repository\ExpenseRepository;
use App\Repository\IncomeRepository;
use Bunny\AbstractClient;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BankStatementController extends AbstractController
{
    private AbstractClient $client;

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly IncomeRepository $incomeRepository,
        private readonly ExpenseRepository $expenseRepository
    ) {
        //$this->client = RabbitMqClientFactory::create();
    }

    /**
     * @throws Exception
     */
    #[Route('/generate', name: 'app_generate', methods: ['GET'])]
    public function generate(Request $request): JsonResponse
    {
//        $this->client = RabbitMqClientFactory::create();
//        $channel = $this->client->channel();

        $dateTo = new DateTime('2024-01-24 00:00:00');
        $dateFrom = new DateTime('2023-01-31 00:00:00');

        $statement = '';

        $this->incomeRepository->findAll();

//        $incomes = $this->incomeRepository->findByBetweenDates($dateFrom, $dateTo);
//        foreach ($incomes as $income) {
//            $statement .= sprintf(
//                    '%s: +%s %s',
//                    $income->getDate()->format('d.m.Y H:i:s'),
//                    $income->getAmount(),
//                    $income->getCurrency(),
//                ) . PHP_EOL;
//        }

//        $expenses = $this->expenseRepository->findByBetweenDates($dateFrom, $dateTo);
//        foreach ($expenses as $expense) {
//            $statement .= sprintf(
//                    '%s: %s %s',
//                    $expense->getDate()->format('d.m.Y H:i:s'),
//                    $expense->getAmount(),
//                    $expense->getCurrency(),
//                ) . PHP_EOL;
//        }

//        $channel = $this->client->channel();
//        $channel->publish('{"paymentId": 1}', exchange: 'events', routingKey: 'payment_succeeded');

        return $this->json([
            'statement' => $statement,
        ]);
    }
}
