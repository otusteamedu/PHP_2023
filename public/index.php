<?php
declare(strict_types=1);

echo 'Запрос принял сервер ' . $_SERVER['HOSTNAME'];
echo "<br>";

//hostname название docker контейнера
$connect = mysqli_connect('mysql-db', 'mysql', 'mysql', 'test');

if ($connect->connect_error) {
    die("Ошибка подключения: " . $connect->connect_error);
}

echo "Подключение успешно!";

phpinfo();