<?php

namespace IilyukDmitryi\App\Application\UseCase;

use Exception;
use IilyukDmitryi\App\Application\Builder\BankStatementRequestModelBuilder;
use IilyukDmitryi\App\Application\Dto\MessageReciveResult;
use IilyukDmitryi\App\Domain\Mailer\MailerInterface;
use IilyukDmitryi\App\Domain\Model\BankStatementModel;
use IilyukDmitryi\App\Domain\Model\BankStatementRequestModel;
use IilyukDmitryi\App\Domain\Repository\BankStatementReciverInterface;


class ReciveBankStatementUseCase
{
    public function __construct(private BankStatementReciverInterface $reciver, private MailerInterface $mailer)
    {
        $this->reciver = $reciver;
    }

    /**
     * @throws Exception
     */
    public function exec(): MessageReciveResult
    {
        $isSendEmail = false;
        $isRecive = false;
        $messageBankStatement = $this->reciver->recive();
        if ($messageBankStatement->getEmail() &&
            $messageBankStatement->getDateStart() &&
            $messageBankStatement->getDateEnd()
        ) {
            $isRecive = true;
            $bankStatementRequestModel = BankStatementRequestModelBuilder::createFromRequest($messageBankStatement);
            $isSendEmail = $this->sendStatementToEmail($bankStatementRequestModel);
        }
        return new MessageReciveResult($isRecive, $isSendEmail);
    }

    /**
     * @throws Exception
     */
    private function sendStatementToEmail(BankStatementRequestModel $bankStatementRequestModel): bool
    {
        $bankStatement = new BankStatementModel(
            $bankStatementRequestModel->getDateStart(),
            $bankStatementRequestModel->getDateEnd()
        );
        $emailTo = $bankStatementRequestModel->getEmail();
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
