<?php

namespace IilyukDmitryi\App\Infrastructure\Mailer;

use IilyukDmitryi\App\Domain\Mailer\MailerInterface;
use IilyukDmitryi\App\Infrastructure\Config\ConfigApp;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer implements MailerInterface
{
    /**
     * @param string $emailTo
     * @param string $subject
     * @param string $message
     * @return bool
     * @throws Exception
     */
    public function sendMail(string $emailTo, string $subject, string $message): bool
    {
        $mail = $this->getMailer();
        $mail->addAddress($emailTo);
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
        return true;
    }

    /**
     * @throws Exception
     */
    private function getMailer(): PHPMailer
    {
        $settings = ConfigApp::get();

        if (!$settings->getMailerSmptHost() || !$settings->getMailerSmptPort() ||
            !$settings->getMailerSmptUser() || $settings->getMailerSmptPass() || $settings->getMailerSmptEmailFrom()) {
            throw new Exception('Необходимые параметры для работы почты отсутствуют!');
        }

        $mail = new PHPMailer(true);
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = $settings->getMailerSmptHost();
        $mail->SMTPAuth = true;
        $mail->Username = $settings->getMailerSmptUser();
        $mail->Password = $settings->getMailerSmptPass();
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $settings->getMailerSmptPort();
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $mail->setFrom($settings->getMailerSmptEmailFrom(), 'Mailer');

        return $mail;
    }
}
