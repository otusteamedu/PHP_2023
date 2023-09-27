<?php

namespace IilyukDmitryi\App\Application\UseCase;

use Exception;
use IilyukDmitryi\App\Application\Builder\BankStatementMessageBuilder;
use IilyukDmitryi\App\Application\Contract\Messenger\MessengerInterface;
use IilyukDmitryi\App\Application\Dto\BankStatementRequest;
use IilyukDmitryi\App\Application\Message\BankStatementMessage;

class SendBankStatementUseCase
{

    public function __construct(protected readonly MessengerInterface $messenger)
    {
    }

    /**
     * @throws Exception
     */
    public function exec(BankStatementRequest $messageSendRequest): void
    {
        $bankStatementMessage = BankStatementMessageBuilder::createFromRequest($messageSendRequest);
        $this->messenger->send($bankStatementMessage);
    }


}
