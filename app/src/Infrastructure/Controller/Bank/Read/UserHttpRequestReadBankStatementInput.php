<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Bank\Read;

use App\Application\UseCase\BankStatement\ReadBankStatementInput;
use App\Domain\ValueObject\Id;
use App\Infrastructure\Request\UserHttpRequest;

final class UserHttpRequestReadBankStatementInput extends UserHttpRequest implements ReadBankStatementInput
{
    public function getBankStatementId(): Id
    {
        return new Id($this->getRequest()->get('bank_statement_id'));
    }
}
