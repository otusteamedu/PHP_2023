<?php

session_start();

echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME']."<br><br>";

// Установка значения в сессию
$_SESSION['username'] = 'John';

// Получение значения из сессии
$username = $_SESSION['username'];

// Вывод значения
echo "Привет, $username!";
