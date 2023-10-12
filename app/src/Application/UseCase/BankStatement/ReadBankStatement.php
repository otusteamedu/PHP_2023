<?php

declare(strict_types=1);

namespace App\Application\UseCase\BankStatement;

use App\Domain\Entity\BankStatement;
use App\Domain\Entity\User;
use App\Domain\Exception\NotFoundException;
use App\Domain\Exception\SecurityException;
use App\Domain\Repository\BankStatementRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;

final class ReadBankStatement
{
    public function __construct(
        private readonly BankStatementRepositoryInterface $bankStatementRepository,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws SecurityException
     */
    public function handle(ReadBankStatementInput $input): BankStatement
    {
        $user = $this->userRepository->firstById($input->getCurrentUserId());
        $bankStatement = $this->bankStatementRepository->firstOrFailById($input->getBankStatementId());
        $this->guardAccess($user, $bankStatement);

        return $bankStatement;
    }

    /**
     * @throws SecurityException
     */
    private function guardAccess(User $user, BankStatement $bankStatement): void
    {
        if (!$bankStatement->getUser()->getId()->isEq($user->getId())) {
            throw new SecurityException('Access denied!');
        }
    }
}
