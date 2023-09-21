<?php

namespace IilyukDmitryi\App\Application\UseCase;

use Exception;
use IilyukDmitryi\App\Application\Contract\Mailer\MailerInterface;
use IilyukDmitryi\App\Application\Contract\Messenger\MessengerInterface;
use IilyukDmitryi\App\Application\Dto\MessageReciveResult;
use IilyukDmitryi\App\Application\Message\BankStatementMessage;
use IilyukDmitryi\App\Domain\Model\BankStatementModel;



class ReciveBankStatementUseCase
{
    public function __construct(protected readonly MessengerInterface $messenger, protected readonly MailerInterface $mailer)
    {
    }

    /**
     * @throws Exception
     */
    public function exec(): MessageReciveResult
    {
        $isSendEmail = false;
        $isRecive = false;
        $messageBankStatement = new BankStatementMessage();
        if($this->messenger->recive($messageBankStatement)){
            $isRecive = true;
            $isSendEmail = $this->sendStatementToEmail($messageBankStatement);
        }

        return new MessageReciveResult($isRecive, $isSendEmail);
    }

    /**
     * @throws Exception
     */
    private function sendStatementToEmail(BankStatementMessage $bankStatementMessage): bool
    {
        $bankStatement = new BankStatementModel(
            $bankStatementMessage->getDateStart(),
            $bankStatementMessage->getDateEnd()
        );
        $emailTo = $bankStatementMessage->getEmail();
        $body = $this->getMailBody($bankStatement);
        $subject = "Выписка по банковскому счету за период c " .
            $bankStatement->getDateStart()->format('d.m.Y') . " по " .
            $bankStatement->getDateEnd()->format('d.m.Y');
        return $this->mailer->sendMail($emailTo, $subject, $body);
    }

    private function getMailBody(BankStatementModel $bankStatement): string
    {
        $body = '';
        foreach ($bankStatement->getBankStatement() as $item) {
            $body .= $item['date']->format('d.m.Y') . ' - ' . $item['value'] . PHP_EOL;
        }
        return $body;
    }
}
