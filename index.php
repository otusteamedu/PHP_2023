<?php

require 'vendor/autoload.php';

// Используем Predis для подключения к Redis
$client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'redis',
    'port'   => 6379,
]);

// Определяем источники для битовой маски
$sources = [
    'планер' => 1,
    'силовая установка' => 2,
    'шасси' => 4,
    'тормозная система' => 8,
    'бортовое оборудование' => 16,
];

// Функция для получения событий по одному или нескольким источникам
function getEventsBySources($client, $sources, $sourceNames) {
    // Сначала получаем все события, отсортированные по важности
    $allEvents = $client->zRevRange('events', 0, -1);

    // Создаем битовую маску для запрашиваемых источников
    $sourceMask = 0;
    foreach ($sourceNames as $name) {
        $sourceMask |= $sources[$name];
    }

    // Фильтруем события по битовой маске источников
    $filteredEvents = [];
    foreach ($allEvents as $eventJson) {
        $event = json_decode($eventJson, true);
        $eventSourceMask = 0;
        foreach ($event['source'] as $eventSource) {
            $eventSourceMask |= $sources[$eventSource];
        }
        if (($eventSourceMask & $sourceMask) === $sourceMask) {
            $filteredEvents[] = $event;
        }
    }

    return $filteredEvents;
}

if ($argc > 1) {
    // Собираем источники из аргументов командной строки
    $inputSources = array_slice($argv, 1);
    $events = getEventsBySources($client, $sources, $inputSources);
    print_r($events);
} else {
    echo "Использование: php script.php [источники]\n";
}

/*// Пример запросов
$eventsForPlane = getEventsBySources($client, $sources, ['планер']);
$eventsForEngine = getEventsBySources($client, $sources, ['силовая установка']);
$eventsForEngineAndPlane = getEventsBySources($client, $sources, ['силовая установка', 'планер']);
$eventsForEngineAndPlaneAndChassis = getEventsBySources($client, $sources, ['силовая установка', 'планер', 'шасси']);
$eventsForEngineAndOnboardEquipment = getEventsBySources($client, $sources, ['силовая установка', 'бортовое оборудование']);

// Выводим результаты
echo "События для 'планер':\n";
print_r($eventsForPlane);

echo "\nСобытия для 'силовая установка':\n";
print_r($eventsForEngine);

echo "\nСобытия для 'силовая установка + планер':\n";
print_r($eventsForEngineAndPlane);

echo "\nСобытия для 'силовая установка + планер + шасси':\n";
print_r($eventsForEngineAndPlaneAndChassis);

echo "\nСобытия для 'силовая установка + бортовое оборудование':\n";
print_r($eventsForEngineAndOnboardEquipment);*/