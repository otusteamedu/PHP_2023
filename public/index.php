<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\MyApp;

try {
    $myApp = new MyApp();
    $myApp->init(); // Создаем индекс, его еще нет
    $result = $myApp->search(); // Поиск по переданным аргументам
    print_r($result);
} catch (Throwable $th) {
    print_r($th->getMessage());
}
