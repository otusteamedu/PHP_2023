<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Command\ProcessBankStatementCommand;
use App\Application\Dto\BankStatementDto;
use App\Infrastructure\Component\Publisher;

class CreateBankStatement
{
    public function __construct(
        private readonly Publisher $publisher,
    ) {
    }

    public function handle(BankStatementDto $dto): void
    {
        $this->publisher->dispatch(new ProcessBankStatementCommand(
            $dto->chatId,
            $dto->dateFrom,
            $dto->dateTo,
        ));
    }
}
