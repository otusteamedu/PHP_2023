<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/helpers.php';

// Run app
$app = new Common\Application\WebApp(
    container(),
    config()
);

$app->run();