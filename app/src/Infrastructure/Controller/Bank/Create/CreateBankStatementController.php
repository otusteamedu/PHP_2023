<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Bank\Create;

use App\Application\UseCase\CreateBankStatement;
use App\Application\UseCase\CreateBankStatementInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateBankStatementController extends AbstractController
{
    public function __construct(
        private readonly CreateBankStatement $createBankStatement,
    ) {
    }

    public function handle(CreateBankStatementInput $input): JsonResponse
    {
        $this->createBankStatement->handle($input);

        return new JsonResponse([
            'result' => true,
        ]);
    }
}
