<?php

namespace Rabbit\Daniel\Notification;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailNotification implements NotificationInterface
{
    /**
     * @var PHPMailer Экземпляр PHPMailer для отправки электронной почты.
     */
    private $mailer;

    /**
     * Конструктор класса EmailNotification.
     *
     * @param PHPMailer $mailer Предварительно настроенный экземпляр PHPMailer.
     */
    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Отправляет уведомление по электронной почте.
     *
     * @param string $to Адрес электронной почты получателя.
     * @param string $message Текст сообщения.
     * @param array $options Дополнительные параметры, такие как тема письма.
     * @return bool Возвращает true, если сообщение было успешно отправлено.
     */
    public function send(string $to, string $message, array $options = []): bool
    {
        try {
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $options['subject'] ?? 'Без темы'; // Тема письма
            $this->mailer->Body    = $message;  // Текст сообщения

            // Проверка на наличие вложений в $options
            if (!empty($options['attachments'])) {
                foreach ($options['attachments'] as $attachment) {
                    $this->mailer->addAttachment($attachment); // Добавление вложений
                }
            }

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            // Обработка ошибки отправки
            // В реальном приложении здесь может быть логирование или другая логика обработки ошибок
            return false;
        }
    }
}