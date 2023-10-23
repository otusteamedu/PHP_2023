<?php

// index.php

require 'vendor/autoload.php';
use Nikitaglobal\Controller\App as App;
$app = new App();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $app->showForm();
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $app->processForm();
    exit();
}


// Обработка POST-запроса от пользователя
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
}
