<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Rabbit\Daniel\App;

$app = new App();
$app->run();