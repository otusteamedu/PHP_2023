<?php

namespace Rabbit\Daniel\Request;

use Rabbit\Daniel\Notification\NotificationInterface;

class RequestHandler
{
    /**
     * Обрабатывает запрос и отправляет уведомление.
     *
     * @param array $requestData Данные запроса.
     * @param NotificationInterface $notifier Экземпляр уведомителя.
     * @return string Ответ об обработке запроса.
     */
    public function handle(array $requestData, NotificationInterface $notifier): string
    {
        // Пример валидации данных запроса (простая проверка)
        if (empty($requestData['startDate']) || empty($requestData['endDate'])) {
            return "Ошибка: Не указаны даты начала или окончания.";
        }

        // В данном контексте, предполагается, что уведомление отправляется сразу,
        // но можно также реализовать логику добавления задачи в очередь на отправку
        $to = 'palm6991@gmail.com'; // Получатель
        $message = "Уведомление: ваш запрос был обработан."; // Пример сообщения

        // Дополнительные параметры, например, тема письма для EmailNotification
        $options = [
            'subject' => 'Запрос обработан'
        ];

        // Отправка уведомления
        $result = $notifier->send($to, $message, $options);

        if ($result) {
            return "Уведомление отправлено успешно.";
        } else {
            return "Ошибка при отправке уведомления.";
        }
    }
}