<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Mail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Vp\App\Infrastructure\Mail\Contract\SmtpMailerInterface;

class SmtpMailer implements SmtpMailerInterface
{
    private const CHARSET = 'UTF-8';
    private const YANDEX_HOST = 'ssl://smtp.yandex.ru';
    private const SMTP_PORT = 465;
    private const SMTP_FROM_NAME = 'Application for handling pending requests';

    private PHPMailer $mail;

    /**
     * @throws Exception
     */
    public function __construct(string $smtpFrom, string $smtpUser, string $smtpPassword)
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->CharSet = self::CHARSET;
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;
        $this->mail->Host = self::YANDEX_HOST;
        $this->mail->Port = self::SMTP_PORT;
        $this->mail->Username = $smtpUser;
        $this->mail->Password = $smtpPassword;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        $this->mail->setFrom($smtpFrom, self::SMTP_FROM_NAME);
    }

    /**
     * @throws Exception
     */
    public function send(string $email, string $subject, string $message): void
    {
        $this->mail->addAddress($email);
        $this->mail->Subject = $subject;
        $this->mail->Body = $message;
        $this->mail->send();
    }
}
