<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Bank\Create;

use App\Application\UseCase\CreateBankStatementInput;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Request\HttpRequest;

final class HttpRequestCreateBankStatementInput extends HttpRequest implements CreateBankStatementInput
{
    public function getEmail(): Email
    {
        return new Email($this->getRequest()->get('email'));
    }

    public function getDateFrom(): \DateTimeInterface
    {
        return new \DateTimeImmutable($this->getRequest()->get('dateFrom'));
    }

    public function getDateTo(): \DateTimeInterface
    {
        return new \DateTimeImmutable($this->getRequest()->get('dateTo'));
    }
}
