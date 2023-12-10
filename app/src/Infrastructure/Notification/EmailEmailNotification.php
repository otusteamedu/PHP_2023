<?php

namespace App\Infrastructure\Notification;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\SendmailTransport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;

class EmailEmailNotification implements EmailNotificationInterface
{
    private Mailer $mailer;
    private Message $email;

    public function __construct()
    {
        $transport = new SendmailTransport();
        $this->mailer = new Mailer($transport);

        $this->email = (new Email())
            ->from($_ENV['SENDER'])
            ->priority(Email::PRIORITY_HIGHEST);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(string $message, string $subject, string $email): void
    {
        /*
        $this->email
            ->to($email)
            ->text($message)
            ->subject($subject);
        $this->mailer->send($this->email);
        */
    }
}
