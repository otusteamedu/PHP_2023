<?php

namespace IilyukDmitryi\App\Infrastructure\Repository;

use Exception;
use IilyukDmitryi\App\Application\Dto\MessageSendRequest;
use IilyukDmitryi\App\Domain\Model\BankStatementRequestModel;
use IilyukDmitryi\App\Domain\Repository\BankStatementSenderInterface;
use IilyukDmitryi\App\Infrastructure\Broker\Base\SenderBrokerInterface;
use IilyukDmitryi\App\Infrastructure\Broker\BrokerApp;

class  BankStatementSender implements BankStatementSenderInterface
{
    private ?SenderBrokerInterface $sender;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->sender = BrokerApp::getSender();
    }

    /**
     * @param BankStatementRequestModel $bankStatementRequestModel
     * @return void
     */
    public function send(BankStatementRequestModel $bankStatementRequestModel): void
    {
        $body = [
            'dateStart' => $bankStatementRequestModel->getDateStart()->format('Y-m-d'),
            'dateEnd' => $bankStatementRequestModel->getDateEnd()->format('Y-m-d'),
            'email' => $bankStatementRequestModel->getEmail(),
        ];
        $bodyJson = json_encode($body);
        $this->sender->send(new MessageSendRequest($bodyJson));
    }
}
