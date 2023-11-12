<?php

declare(strict_types=1);

require '../vendor/autoload.php';
require_once '../src/config.php';

use User\Php2023\Infrastructure\Controllers\StatementController;


$response = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['start_date']) && $_POST['start_date']) {
    try {
        $response = StatementController::handlePostRequest($container);
    } catch (Exception $e) {
        $response = 'Ошибка: ' . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'form.php';
}
