<?php

// index.php

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
use Nikitaglobal\Controller\App as App;
$app = new App();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rabbitQuere = new Nikitaglobal\Controller\RabbitQueue();
    $result = $rabbitQuere->add('baning_queue', $app->prepareData($_POST));
    $app->processResult($result);
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $app->showForm();
}
