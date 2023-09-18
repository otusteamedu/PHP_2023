<?php

namespace IilyukDmitryi\App\Domain\Repository;

use IilyukDmitryi\App\Application\Dto\MessageBankStatement;

interface BankStatementReciverInterface
{
    public function recive(): MessageBankStatement;
}
