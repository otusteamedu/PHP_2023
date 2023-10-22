<?php

require 'vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

require 'config.php';
// Подключение к RabbitMQ
$connection = new AMQPStreamConnection($_ENV['RABBITMQ_HOST'], $_ENV['RABBITMQ_PORT'], $_ENV['RABBITMQ_USER'], $_ENV['RABBITMQ_PASSWORD']);
$channel = $connection->channel();

// Определение очереди
$queueName = 'banking_queue';
$channel->queue_declare($queueName, false, false, false, false);

echo "Ожидание запросов на банковскую выписку. Для выхода, нажмите CTRL+C\n";

// Функция для обработки сообщений из очереди
$callback = function ($message) {
    // Обработайте сообщение (банковскую выписку)
    $statement = $message->body;

    // Добавьте код для отправки банковской выписки по email или Telegram

    // $telegramBotToken;
    // $telegramChatId;
    echo "Банковская выписка успешно обработана: $statement\n";

    $message->ack();
};

// Подписка на очередь
$channel->basic_consume($queueName, '', false, false, false, false, $callback);

// Ожидание и обработка сообщений из очереди
while (count($channel->callbacks)) {
    $channel->wait();
}

// Закрытие соединения
$channel->close();
$connection->close();
