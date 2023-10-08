<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Command\ProcessBankStatementCommand;
use App\Application\Component\PublisherInterface;

final class CreateBankStatement
{
    public function __construct(
        private readonly PublisherInterface $publisher,
    ) {
    }

    public function handle(CreateBankStatementInput $input): void
    {
        $this->publisher->dispatch(new ProcessBankStatementCommand(
            $input->getEmail(),
            $input->getDateFrom(),
            $input->getDateTo(),
        ));
    }
}
