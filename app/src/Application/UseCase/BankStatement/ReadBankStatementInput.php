<?php

declare(strict_types=1);

namespace App\Application\UseCase\BankStatement;

use App\Domain\ValueObject\Id;

interface ReadBankStatementInput
{
    public function getBankStatementId(): Id;

    public function getCurrentUserId(): Id;
}
