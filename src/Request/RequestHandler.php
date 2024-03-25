<?php

namespace Rabbit\Daniel\Request;

use Rabbit\Daniel\Notification\NotificationInterface;

class RequestHandler
{
    public function handle(array $requestData, NotificationInterface $notifier): string
    {
        if (empty($requestData['startDate']) || empty($requestData['endDate'])) {
            return "Ошибка: Не указаны даты начала или окончания.";
        }

        $message = "Уведомление: ваш запрос был обработан.";

        $options = [
            'subject' => 'Запрос обработан'
        ];

        $result = $notifier->send($requestData['email'], $message, $options);

        if ($result) {
            return "Уведомление отправлено успешно.";
        } else {
            return "Ошибка при отправке уведомления.";
        }
    }
}