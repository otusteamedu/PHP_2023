<?php

declare(strict_types=1);

namespace App\Application\Presenter;

use App\Application\ViewModel\BankStatementViewModel;
use App\Domain\Entity\BankStatement;

final class BankStatementPresenter
{
    public function __construct(
        private readonly IdPresenter $idPresenter,
    ) {
    }

    public function present(BankStatement $bankStatement): BankStatementViewModel
    {
        return new BankStatementViewModel(
            $this->idPresenter->present($bankStatement->getId()),
            $bankStatement->getStatus()->value,
        );
    }
}
