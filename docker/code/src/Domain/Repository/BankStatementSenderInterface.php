<?php

namespace IilyukDmitryi\App\Domain\Repository;

use IilyukDmitryi\App\Domain\Model\BankStatementRequestModel;

interface BankStatementSenderInterface
{
    public function send(BankStatementRequestModel $bankStatementRequestModel): void;

}
