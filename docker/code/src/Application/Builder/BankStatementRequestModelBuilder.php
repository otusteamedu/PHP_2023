<?php

namespace IilyukDmitryi\App\Application\Builder;

use DateTime;
use Exception;
use IilyukDmitryi\App\Application\Dto\MessageBankStatement;
use IilyukDmitryi\App\Domain\Model\BankStatementRequestModel;

class BankStatementRequestModelBuilder
{
    /**
     * @throws Exception
     */
    public static function createFromRequest(MessageBankStatement $messageBankStatement): BankStatementRequestModel
    {
        $dateStart = new DateTime($messageBankStatement->getDateStart());
        $dateEnd = new DateTime($messageBankStatement->getDateEnd());
        $email = $messageBankStatement->getEmail();

        return new BankStatementRequestModel($dateStart, $dateEnd, $email);
    }
}
