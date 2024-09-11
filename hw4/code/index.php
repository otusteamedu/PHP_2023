<?php

require_once 'vendor/autoload.php';
use Alexgaliy\AppValidator;
$app = new AppValidator\App();
echo " Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
?>

<form action="" method="post">
    <label for="string">Введите строку:</label>
    <input name="string" id="string" type="text">
    <button type="submit">Отправить</button>
</form>

<? echo $app->init();
