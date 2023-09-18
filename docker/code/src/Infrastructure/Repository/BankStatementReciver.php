<?php

namespace IilyukDmitryi\App\Infrastructure\Repository;

use Exception;
use IilyukDmitryi\App\Application\Dto\MessageBankStatement;
use IilyukDmitryi\App\Domain\Repository\BankStatementReciverInterface;
use IilyukDmitryi\App\Infrastructure\Broker\Base\ReciverBrokerInterface;
use IilyukDmitryi\App\Infrastructure\Broker\BrokerApp;

class  BankStatementReciver implements BankStatementReciverInterface
{
    private ?ReciverBrokerInterface $reciver;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->reciver = BrokerApp::getReciver();
    }

    /**
     * @return MessageBankStatement
     */
    public function recive(): MessageBankStatement
    {
        if (rand() % 2 == 0) {
            sleep(5);
            $messageSendFormData = new MessageBankStatement("", "", "");
        } else {
            sleep(2);
            $messageReciveResponse = $this->reciver->recive();
            $body = $messageReciveResponse->getBody();
            if ($body) {
                $body = json_decode($body, true);
                $messageSendFormData = new MessageBankStatement(
                    ($body['dateStart'] ?: ""),
                    ($body['dateEnd'] ?: ""),
                    ($body['email'] ?: "")
                );
            } else {
                $messageSendFormData = new MessageBankStatement("", "", "");
            }
        }
        return $messageSendFormData;
    }
}
