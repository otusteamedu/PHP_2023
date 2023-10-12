<?php

declare(strict_types=1);

namespace App\Application\UseCase\BankStatement;

use App\Application\Command\ProcessBankStatementCommand;
use App\Application\Component\PublisherInterface;
use App\Domain\Constant\BankStatementStatus;
use App\Domain\Entity\BankStatement;
use App\Domain\Repository\BankStatementRepositoryInterface;
use App\Domain\Repository\FlusherInterface;
use App\Domain\Repository\PersisterInterface;
use App\Domain\Repository\UserRepositoryInterface;

final class CreateBankStatement
{
    public function __construct(
        private readonly BankStatementRepositoryInterface $bankStatementRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly PersisterInterface $persister,
        private readonly FlusherInterface $flusher,
        private readonly PublisherInterface $publisher,
    ) {
    }

    public function handle(CreateBankStatementInput $input): BankStatement
    {
        $user = $this->userRepository->firstById($input->getCurrentUserId());
        $bankStatement = new BankStatement(
            $this->bankStatementRepository->nextId(),
            $user,
            BankStatementStatus::NEW,
        );
        $this->persister->persist($bankStatement);
        $this->flusher->flush();

        $this->publisher->dispatch(new ProcessBankStatementCommand(
            $bankStatement->getId(),
            $input->getDateFrom(),
            $input->getDateTo(),
        ));

        return $bankStatement;
    }
}
