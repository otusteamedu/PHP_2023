<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Bank\Create;

use App\Application\UseCase\BankStatement\CreateBankStatementInput;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Request\UserHttpRequest;

final class UserHttpRequestCreateBankStatementInput extends UserHttpRequest implements CreateBankStatementInput
{
    public function getDateFrom(): \DateTimeInterface
    {
        return new \DateTimeImmutable($this->getRequest()->get('dateFrom'));
    }

    public function getDateTo(): \DateTimeInterface
    {
        return new \DateTimeImmutable($this->getRequest()->get('dateTo'));
    }
}
