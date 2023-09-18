<?php

namespace IilyukDmitryi\App\Application\UseCase;

use Exception;
use IilyukDmitryi\App\Application\Builder\BankStatementRequestModelBuilder;
use IilyukDmitryi\App\Application\Dto\MessageBankStatement;
use IilyukDmitryi\App\Domain\Repository\BankStatementSenderInterface;

class SendBankStatementUseCase
{
    private BankStatementSenderInterface $sender;

    public function __construct(BankStatementSenderInterface $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @throws Exception
     */
    public function exec(MessageBankStatement $messageSendRequest): void
    {
        $bankStatementRequestModel = BankStatementRequestModelBuilder::createFromRequest($messageSendRequest);
        $this->sender->send($bankStatementRequestModel);
    }
}
