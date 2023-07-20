<?php

require_once __DIR__ . '/vendor/autoload.php';

use Predis\Client;

// Получение настроек доступа к Redis из переменных окружения
$redisHost = getenv('REDIS_HOST');
$redisPort = getenv('REDIS_PORT');
$redisPassword = getenv('REDIS_PASSWORD');

// Создание экземпляра клиента Redis
$redis = new Client([
    'scheme' => 'tcp',
    'host' => $redisHost,
    'port' => $redisPort,
    'password' => $redisPassword,
]);

// Удаление существующих данных
$redis->del('events');

// Генерация произвольных данных
function generateRandomData()
{
    $data = [];
    $data['priority'] = mt_rand(1000, 5000);
    $data['conditions'] = [
        'param1' => mt_rand(1, 5),
        'param2' => mt_rand(1, 5)
    ];
    $data['event'] = 'Event ' . mt_rand(1, 100);

    return $data;
}

// Количество событий для добавления
$totalEvents = 1000;

// Добавление событий в Redis
for ($i = 0; $i < $totalEvents; $i++) {
    $eventData = generateRandomData();
    $redis->rpush('events', json_encode($eventData));
}

echo "Dummy data added to Redis.";
