<?php

namespace Rabbit\Daniel\Notification;

interface NotificationInterface
{
    /**
     * Отправляет уведомление.
     *
     * @param string $to Адресат уведомления. Может быть адресом электронной почты, идентификатором чата в Telegram и т.д.
     * @param string $message Сообщение, которое нужно отправить.
     * @param array $options Дополнительные параметры уведомления в виде ассоциативного массива.
     * @return mixed Результат отправки уведомления.
     */
    public function send(string $to, string $message, array $options = []);
}