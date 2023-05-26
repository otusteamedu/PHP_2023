<?php

declare(strict_types=1);

namespace Vp\App\Application\Handler;

use PhpAmqpLib\Message\AMQPMessage;
use Vp\App\Application\Contract\MailerInterface;
use Vp\App\Application\Handler\Contract\EmailHandlerInterface;
use Vp\App\Application\UseCase\Contract\StatementGeneratorInterface;

class BankStatementEmailHandler implements EmailHandlerInterface
{
    private StatementGeneratorInterface $generator;
    private MailerInterface $mailer;

    public function __construct(StatementGeneratorInterface $generator, MailerInterface $mailer)
    {
        $this->generator = $generator;
        $this->mailer = $mailer;
    }
    public function handle(AMQPMessage $message): void
    {
        [$dateStart, $dateEnd] = $this->getPeriod($message);
        $email = $this->getEmail($message);

        $statement = $this->generator->generate($dateStart, $dateEnd);
        $this->mailer->send($email, 'Bank Statement', $statement);
    }

    private function getPeriod(AMQPMessage $message): array
    {
        $messageParams = $this->getMessageParams($message);
        $dateStart = $messageParams['dateStart'];
        $dateEnd = $messageParams['dateEnd'];
        return [$dateStart, $dateEnd];
    }

    private function getEmail(AMQPMessage $message): string
    {
        $messageParams = $this->getMessageParams($message);
        return $messageParams['email'];
    }

    private function getMessageParams(AMQPMessage $message): mixed
    {
        $messageParams = json_decode($message->getBody(), true);
        return $messageParams;
    }
}
