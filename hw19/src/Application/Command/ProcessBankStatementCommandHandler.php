<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Component\ProcessBankStatement;

class ProcessBankStatementCommandHandler
{
    public function __construct(
        private readonly ProcessBankStatement $processBankStatement,
    ) {
    }

    public function handle(ProcessBankStatementCommand $command): void
    {
        $this->processBankStatement->process(
            $command->chatId,
            $command->dateFrom,
            $command->dateTo,
        );
    }
}
