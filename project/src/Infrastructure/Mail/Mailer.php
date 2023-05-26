<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Mail;

use PHPMailer\PHPMailer\Exception;
use Vp\App\Application\Contract\MailerInterface;
use Vp\App\Infrastructure\Mail\Contract\SmtpMailerInterface;

class Mailer implements MailerInterface
{
    private SmtpMailerInterface $smtpMailer;

    public function __construct(SmtpMailerInterface $smtpMailer)
    {
        $this->smtpMailer = $smtpMailer;
    }

    /**
     * @throws Exception
     */
    public function send(string $email, string $subject, string $message): void
    {
        $this->smtpMailer->send($email, $subject, $message);
    }
}
