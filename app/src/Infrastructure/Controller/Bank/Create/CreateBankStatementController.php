<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Bank\Create;

use App\Application\Presenter\BankStatementPresenter;
use App\Application\UseCase\BankStatement\CreateBankStatement;
use App\Application\UseCase\BankStatement\CreateBankStatementInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateBankStatementController extends AbstractController
{
    public function __construct(
        private readonly CreateBankStatement $createBankStatement,
        private readonly BankStatementPresenter $bankStatementPresenter,
    ) {
    }

    public function handle(CreateBankStatementInput $input): JsonResponse
    {
        $bankStatement = $this->createBankStatement->handle($input);

        return new JsonResponse(
            ['data' => $this->bankStatementPresenter->present($bankStatement)],
            201,
        );
    }
}
