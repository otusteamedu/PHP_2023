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
            ->from('sender@example.test')
            ->priority(Email::PRIORITY_HIGHEST)
            ->subject('TEST');
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(string $message, string $email): void
    {
        /*
        $this->email->to($email)->text($message);
        $this->mailer->send($this->email);
        */
        print_r("Отправка сообщения '{$message}' на '{$email}'");
    }
}
