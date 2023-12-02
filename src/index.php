<?php

require __DIR__ . '/../vendor/autoload.php';

use Daniel\Otus\App;

$app = new App();
$app->init($_POST);;
