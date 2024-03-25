<?php

namespace Rabbit\Daniel\Notification;

use Telegram\Bot\Api;

class TelegramNotification implements NotificationInterface
{
    /**
     * @var Api Экземпляр клиента API Telegram.
     */
    private $telegram;

    /**
     * Конструктор класса TelegramNotification.
     *
     * @param Api $telegram Предварительно настроенный экземпляр клиента API Telegram.
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Отправляет уведомление в Telegram.
     *
     * @param string $to Идентификатор чата или канала в Telegram.
     * @param string $message Текст сообщения для отправки.
     * @param array $options Дополнительные параметры (пока не используются).
     * @return bool Возвращает true, если сообщение было успешно отправлено.
     */
    public function send(string $to, string $message, array $options = []): bool
    {
        try {
            $response = $this->telegram->sendMessage([
                'chat_id' => $to,
                'text' => $message
            ]);

            // Проверка успешности отправки сообщения может быть основана на анализе ответа от Telegram API.
            // Здесь предполагается, что если $response не вызвал исключение, то сообщение было успешно отправлено.
            return true;
        } catch (\Exception $e) {
            // Обработка возможных ошибок отправки сообщения.
            // В реальном приложении здесь может быть логирование или другая логика обработки ошибок.
            return false;
        }
    }
}