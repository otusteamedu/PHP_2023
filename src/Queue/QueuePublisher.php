<?php

namespace Rabbit\Daniel\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueuePublisher
{
    /**
     * @var AMQPStreamConnection Подключение к RabbitMQ.
     */
    private $connection;

    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel Канал для коммуникации с RabbitMQ.
     */
    private $channel;

    /**
     * Конструктор класса QueuePublisher.
     *
     * @param AMQPStreamConnection $connection Подключение к RabbitMQ.
     */
    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
        $this->channel = $this->connection->channel();
    }

    /**
     * Публикует сообщение в указанную очередь.
     *
     * @param string $queueName Имя очереди, в которую будет отправлено сообщение.
     * @param string $message Сообщение для отправки.
     * @param array $options Дополнительные опции для сообщения.
     * @return void
     */
    public function publish(string $queueName, string $message, array $options = []): void
    {
        // Объявляем очередь, если она еще не существует
        $this->channel->queue_declare(
            $queueName,
            false, // passive
            true,  // durable
            false, // exclusive
            false  // auto_delete
        );

        // Создаем сообщение
        $msg = new AMQPMessage(
            $message,
            array_merge(['content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT], $options)
        );

        // Публикуем сообщение в очередь
        $this->channel->basic_publish($msg, '', $queueName);
    }

    /**
     * Закрывает канал и подключение.
     */
    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }

    /**
     * Деструктор класса QueuePublisher.
     * Автоматически закрывает канал и подключение при уничтожении объекта.
     */
    public function __destruct()
    {
        $this->close();
    }
}