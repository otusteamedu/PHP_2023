<?php

declare(strict_types=1);

namespace App\Statement;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsEventListener]
final class NotifyUserListener
{
    public function __construct(
        private readonly MailerInterface $mailer
    ) {
    }

    /**
     * Super simple user notifier by email
     *
     * @throws TransportExceptionInterface
     */
    public function __invoke(StatementIsGeneratedEvent $event): void
    {
        $email = (new Email())
            ->from('statement_notifier@mail.com')
            ->to('user@mail.com')
            ->subject('Bank statement')
            ->text("You statement is generated");

        $this->mailer->send($email);
    }
}
