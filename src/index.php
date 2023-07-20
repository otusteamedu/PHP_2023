<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controller\EventController;
use App\Model\EventSystem;
use App\Model\RedisStorage;
use Predis\Client;

// Создание экземпляра RedisStorage с подключением к Redis
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

$storage = new RedisStorage($redis);

// Создание экземпляра EventSystem
$eventSystem = new EventSystem($storage);

// Создание экземпляра EventController
$eventController = new EventController($eventSystem);

// Обработка запроса
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $priority = $_POST['priority'];
        $conditions = $_POST['conditions'];
        $event = $_POST['event'];
        $eventController->addAction($priority, $conditions, $event);
        break;
    case 'clear':
        $eventController->clearAction();
        break;
    case 'find':
        $params = $_POST ?? [];
        $eventController->findMatchingAction($params);
        break;
    default:
        echo "Invalid action.";
        break;
}
