<?php

// populate.php
require_once 'vendor/autoload.php';
require_once 'config.php';

// Подключаемся к базе данных
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS);

// Проверяем подключение к базе данных на наличие ошибок
if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Удаляем базу данных, если она существует
$mysqli->query("DROP DATABASE IF EXISTS " . DB_NAME);

// Создаем новую базу данных
$mysqli->query("CREATE DATABASE " . DB_NAME);

// Выбираем базу данных для дальнейшей работы
$mysqli->select_db(DB_NAME);

// Создаем таблицу "users"
$mysqli->query("CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
)");

// Наполняем таблицу "users" случайными данными
for ($i = 1; $i <= 10; $i++) {
    $name = "User " . $i;
    $email = "user" . $i . "@example.com";

    // Экранируем данные перед добавлением в запрос
    $name = $mysqli->real_escape_string($name);
    $email = $mysqli->real_escape_string($email);

    // Вставляем данные в таблицу "users"
    $mysqli->query("INSERT INTO users (name, email) VALUES ('$name', '$email')");
}

// Закрываем соединение с базой данных
$mysqli->close();

echo "Database populated successfully!";
