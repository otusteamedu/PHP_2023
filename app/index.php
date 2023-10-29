<?php

// index.php

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
use Nikitaglobal\Controller\App as App;
$app = new App();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $app->showTemplate('form');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rabbitQuere = new RabbitQueue();
    $result = $rabbitQuere->add('baning_queue', $app->prepareData($_POST));
    if ($result) {
        $app->showTemplate('success', 'Запрос успешно отправлен в очередь');
    } else {
        $app->showError('error', 'Ошибка при отправке запроса в очередь');
    }
    exit();
}
