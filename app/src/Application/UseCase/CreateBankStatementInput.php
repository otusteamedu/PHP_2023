<?php

declare(strict_types=1);

namespace App\Application\UseCase;

interface CreateBankStatementInput
{
    public function getEmail();

    public function getDateFrom(): \DateTimeInterface;

    public function getDateTo(): \DateTimeInterface;
}
