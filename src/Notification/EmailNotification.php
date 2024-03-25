<?php

namespace Rabbit\Daniel\Notification;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailNotification implements NotificationInterface
{
    private $mailer;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(string $to, string $message, array $options = []): bool
    {
        try {
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $options['subject'] ?? 'Без темы';
            $this->mailer->Body    = $message;

            if (!empty($options['attachments'])) {
                foreach ($options['attachments'] as $attachment) {
                    $this->mailer->addAttachment($attachment);
                }
            }

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}