<?php

declare(strict_types=1);

namespace App\Infrastructure\Component;

use App\Application\Component\EmailSenderInterface;
use App\Domain\ValueObject\Email;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

final class EmailSender implements EmailSenderInterface
{
    private readonly Email $sender;

    public function __construct(
        string $sender,
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger,
    ) {
        $this->sender = new Email($sender);
    }

    public function send(Email $email, string $subject, string $message): void
    {
        $this->logger->info(
            sprintf('%s %s %s', $email, $subject, $message),
        );
        try {
            $this->mailer->send(
                (new \Symfony\Component\Mime\Email())
                    ->from($this->sender->getValue())
                    ->to($email->getValue())
                    ->subject($subject)
                    ->text($message),
            );
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
