<?php

require 'vendor/autoload.php';

$router = require 'routes.php';

$esClient = new Elasticsearch\ClientBuilder::create()->build();
$channelModel = new App\Models\ChannelModel($esClient);
$videoModel = new App\Models\VideoModel($esClient);
$statisticsController = new App\Controllers\StatisticsController($channelModel, $videoModel);
$statisticsView = new App\Views\StatisticsView();

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$routeInfo = $router->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo "405 Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$className, $method] = explode('@', $handler);

        $response = $statisticsController->$method($vars);

        if (is_array($response)) {
            $statisticsView->$method($response);
        } else {
            echo $response;
        }
        break;
}
