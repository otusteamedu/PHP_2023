<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Dto\BankStatementDto;
use App\Application\UseCase\CreateBankStatement;
use App\Entity\Exception\DataException;
use App\Entity\ValueObject\ChatId;
use App\Infrastructure\Component\TelegramSender;
use App\Infrastructure\Repository\ExpenseRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/v1', name: 'bank_statements_api')]
class BankStatementController extends AbstractController
{
    public function __construct(
        readonly LoggerInterface $logger,
        readonly CreateBankStatement $createBankStatement,
        readonly TelegramSender $sender,
        readonly ExpenseRepository $expenseRepository
    ) {
    }

    #[Route('/bank-statements', name: 'bank_statements', methods: 'POST')]
    public function getBankStatement(Request $request): JsonResponse
    {
        try {
            if (
                !$request
                || !$request->request->get('chatId')
                || !$request->request->get('dateFrom')
                || !$request->request->get('dateTo')
            ) {
                throw new DataException('Data no valid');
            }

            $dto = new BankStatementDto();
            $dto->chatId = new ChatId($request->request->get('chatId'));
            $dto->dateFrom = new \DateTime($request->request->get('dateFrom'));
            $dto->dateTo = new \DateTime($request->request->get('dateTo'));

            $this->createBankStatement->handle($dto);

            return $this->json([
                'status' => 200,
                'success' => 'Bank Statement is handling',
            ]);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            return $this->json([
                'status' => 422,
                'errors' => $e->getMessage(),
            ], 422);
        }
    }
}
