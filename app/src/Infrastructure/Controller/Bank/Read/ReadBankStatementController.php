<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Bank\Read;

use App\Application\Presenter\BankStatementPresenter;
use App\Application\UseCase\BankStatement\ReadBankStatement;
use App\Application\UseCase\BankStatement\ReadBankStatementInput;
use App\Domain\Exception\NotFoundException;
use App\Domain\Exception\SecurityException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ReadBankStatementController extends AbstractController
{
    public function __construct(
        private readonly ReadBankStatement $readBankStatement,
        private readonly BankStatementPresenter $bankStatementPresenter,
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws SecurityException
     */
    public function handle(ReadBankStatementInput $input): JsonResponse
    {
        $bankStatement = $this->readBankStatement->handle($input);

        return new JsonResponse([
            'data' => $this->bankStatementPresenter->present($bankStatement),
        ]);
    }
}
