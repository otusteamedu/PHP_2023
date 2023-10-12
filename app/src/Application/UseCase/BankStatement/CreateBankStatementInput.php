<?php

declare(strict_types=1);

namespace App\Application\UseCase\BankStatement;

use App\Domain\ValueObject\Id;

interface CreateBankStatementInput
{
    public function getDateFrom(): \DateTimeInterface;

    public function getDateTo(): \DateTimeInterface;

    public function getCurrentUserId(): Id;
}
