<?php

namespace IilyukDmitryi\App\Application\UseCase;

use Exception;
use IilyukDmitryi\App\Application\Contract\Mailer\MailerInterface;
use IilyukDmitryi\App\Application\Contract\Messenger\MessengerInterface;
use IilyukDmitryi\App\Application\Contract\Storage\EventStorageInterface;
use IilyukDmitryi\App\Application\Dto\Event;
use IilyukDmitryi\App\Application\Dto\MessageReciveResult;
use IilyukDmitryi\App\Application\Message\TwoNdflMessage;
use IilyukDmitryi\App\Domain\Model\TwoNdflModel;



class ReciveTwoNdflUseCase
{
    public function __construct(protected readonly MessengerInterface $messenger, protected readonly MailerInterface $mailer,protected readonly EventStorageInterface $eventStorage)
    {
    }

    /**
     * @throws Exception
     */
    public function exec(): MessageReciveResult
    {
        $isSendEmail = false;
        $isRecive = false;
        $twoNdflMessage = new TwoNdflMessage();
        if($this->messenger->recive($twoNdflMessage)){
            $isRecive = true;
            $isSendEmail = $this->sendStatementToEmail($twoNdflMessage);
            $this->eventStorage->add(new Event($twoNdflMessage->getUuid(),$twoNdflMessage->getFields(),true));
        }

        return new MessageReciveResult($isRecive, $isSendEmail);
    }

    /**
     * @throws Exception
     */
    private function sendStatementToEmail(TwoNdflMessage $twoNdflMessage): bool
    {
        $twoNdflModel = new TwoNdflModel(
            $twoNdflMessage->getNumMonth(),
        );
        $emailTo = $twoNdflMessage->getEmail();
        $body = $this->getMailBody($twoNdflModel);
        $subject = "Справка 2НДФЛ за  " . $twoNdflModel->getNumMonth() . " мес. ";

        return $this->mailer->sendMail($emailTo, $subject, $body);
    }

    private function getMailBody(TwoNdflModel $twoNdflModel): string
    {
        $body = '';
        foreach ($twoNdflModel->getReference() as $item) {
            $body .= $item['date']->format('d.m.Y') . ' - ' . $item['value'] . PHP_EOL;
        }
        return $body;
    }
}
