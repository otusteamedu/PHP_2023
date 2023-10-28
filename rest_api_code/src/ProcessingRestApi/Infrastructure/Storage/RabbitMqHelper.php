<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage\RabbitMqHelperInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqHelper implements RabbitMqHelperInterface
{
    protected AMQPStreamConnection $connection;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
    }

    public function addToQueue(string $queueName, string $message)
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);

        $msg = new AMQPMessage(
            $message,
            [
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]
        );
        $channel->basic_publish($msg, '', $queueName);

        $channel->close();
        $this->connection->close();
    }

    public function readFromQueue(string $queueName)
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);

        $callback = function ($msg) {
            echo 'Получено сообщение. Тело сообщения: ' . $msg->body . PHP_EOL;
            sleep(5);
            echo 'формируем файл с выпиской' . PHP_EOL;
            echo 'отправляем полученную выписку клиенту' . PHP_EOL;
            echo 'отправляем брокеру подтверждение, что сообщение успешно обработано. Это сообщение будет удалено из очереди.' . PHP_EOL;
            $msg->ack();
        };

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($queueName, '', false, false, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }
    }
}
