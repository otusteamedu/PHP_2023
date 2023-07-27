<?php

// index.php
require_once 'vendor/autoload.php';
require_once 'config.php';

// Подключаемся к базе данных
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Проверяем подключение к базе данных на наличие ошибок
if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Создаем объекты для работы с User и UserGateway
$userGateway = new App\Model\UserGateway($mysqli);

// Получаем всех пользователей из базы данных
$users = $userGateway->findAll();

// Выводим результат в виде простого примера
header('Content-Type: application/json');
echo json_encode($users);
