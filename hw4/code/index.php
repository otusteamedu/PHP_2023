<?php

require_once 'vendor/autoload.php';
use Alexgaliy\AppValidator;
$app = new AppValidator\App();
echo " Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
echo $app->init();
