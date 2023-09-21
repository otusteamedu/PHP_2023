<?php

namespace IilyukDmitryi\App\Infrastructure\Mailers;

use IilyukDmitryi\App\Application\Contract\Mailer\MailerInterface;
use IilyukDmitryi\App\Infrastructure\Config\ConfigApp;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer implements MailerInterface
{
    private $mail;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->initMailer();
    }

    /**
     * @param string $emailTo
     * @param string $subject
     * @param string $message
     * @return bool
     * @throws Exception
     */
    public function sendMail(string $emailTo, string $subject, string $message): bool
    {

        $this->mail->addAddress($emailTo);
        $this->mail->isHTML(false);
        $this->mail->Subject = $subject;
        $this->mail->Body = $message;
        return $this->mail->send();
    }

    /**
     * @throws Exception
     */
    private function initMailer(): void
    {
        $settings = ConfigApp::get();

        if (!$settings->getMailerSmptHost() || !$settings->getMailerSmptPort() ||
            !$settings->getMailerSmptUser() || $settings->getMailerSmptPass() || $settings->getMailerSmptEmailFrom()) {
            throw new Exception('Необходимые параметры для работы почты отсутствуют!');
        }

        $this->mail = new PHPMailer(true);
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();
        $this->mail->Host = $settings->getMailerSmptHost();
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $settings->getMailerSmptUser();
        $this->mail->Password = $settings->getMailerSmptPass();
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = $settings->getMailerSmptPort();
        $this->mail->CharSet = PHPMailer::CHARSET_UTF8;
        $this->mail->setFrom($settings->getMailerSmptEmailFrom(), 'Mailer');
    }
}
