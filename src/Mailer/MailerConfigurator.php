<?php

namespace Rabbit\Daniel\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailerConfigurator
{
    /**
     * Создает и возвращает настроенный экземпляр PHPMailer.
     *
     * @param array $config Конфигурация для PHPMailer.
     * @return PHPMailer Настроенный экземпляр PHPMailer.
     * @throws Exception Если произошла ошибка при настройке PHPMailer.
     */
    public static function configure(array $config): PHPMailer
    {
        $mailer = new PHPMailer(true); // Включение исключений для отладки

        try {
            // Основные настройки сервера
            $mailer->isSMTP();
            $mailer->Host       = $config['host'];
            $mailer->SMTPAuth   = $config['smtp_auth'];
            $mailer->Username   = $config['username'];
            $mailer->Password   = $config['password'];
            $mailer->SMTPSecure = $config['smtp_secure'];
            $mailer->Port       = $config['port'];

            // Дополнительные настройки
            $mailer->setFrom($config['from_email'], $config['from_name']);
            if (!empty($config['reply_to'])) {
                $mailer->addReplyTo($config['reply_to']['email'], $config['reply_to']['name']);
            }

            // Опционально: настройки для разработки и отладки
            if (isset($config['smtp_debug'])) {
                $mailer->SMTPDebug = $config['smtp_debug']; // Включение дебаг-режима (SMTP::DEBUG_SERVER для подробного логирования)
            }

            return $mailer;
        } catch (Exception $e) {
            // В реальном приложении здесь может быть логирование или другая логика обработки ошибок
            throw $e;
        }
    }
}