<?php

require __DIR__ . '/vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$elasticsearchHost = $_ENV['ELASTICSEARCH_HOST'];
$elasticsearchPort = $_ENV['ELASTICSEARCH_PORT'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

if ($httpMethod === 'GET') {
    if ($uri === '/statistics') {
        // Обработка запроса статистики
        $queryParams = $_GET;
        $channelId = $queryParams['channelId'] ?? 1;
        $esClient = ClientBuilder::create()->setHosts(["{$elasticsearchHost}:{$elasticsearchPort}"])->build();
        $statisticsController = new App\Controllers\StatisticsController($esClient);
        $statisticsView = new App\Views\StatisticsView();
        $response = $statisticsController->showStatistics(['channelId' => $channelId]);

        if (is_array($response)) {
            $statisticsView->showStatistics($response);
        } else {
            echo $response;
        }
    } elseif ($uri === '/top-channels') {
        // Обработка запроса топ-каналов
        $queryParams = $_GET;
        $n = $queryParams['n'] ?? 5;

        $esClient = ClientBuilder::create()->setHosts(["{$elasticsearchHost}:{$elasticsearchPort}"])->build();
        $statisticsController = new App\Controllers\StatisticsController($esClient);
        $statisticsView = new App\Views\StatisticsView();
        $response = $statisticsController->topChannels(['n' => $n]);
        $statisticsView->topChannels($response);
    } else {
        echo "404 Not Found";
    }
} else {
    echo "405 Method Not Allowed";
}
