<?php
declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\DTO\Builder\OrderBankStatementDTOBuilder;
use App\Service\BankStatementService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/bank_statement', name: 'api_v1_bank_statement_')]
class BankStatementController extends AbstractController
{
    public function __construct(
        private readonly BankStatementService         $bankStatementService,
        private readonly OrderBankStatementDTOBuilder $bankStatementDTOBuilder,
    ) {
    }

    /**
     * @throws Exception
     */
    #[Route('', name: 'order', methods: ['POST'])]
    public function order(Request $request): Response
    {
        $orderBankStatementDTO = $this->bankStatementDTOBuilder->buildFromArray($request->getPayload()->all());

        $this->bankStatementService->orderBankStatementAsync($orderBankStatementDTO);
        $message = 'Выписка формируется, после создания вам придет уведомление';

        return $this->json(['message' => $message], Response::HTTP_OK);
    }
}
