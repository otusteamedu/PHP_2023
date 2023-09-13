<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw19\AccountStatement;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class MessageReceiver
{
    public function run(AMQPStreamConnection $connection, string $queueName): void
    {
        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);

        echo "Ожидаем сообщения из очереди." . PHP_EOL;

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
