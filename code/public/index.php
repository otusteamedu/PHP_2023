<?php

require dirname(__DIR__) . '/vendor/autoload.php';

session_start();

use Radovinetch\Code\App;

$app = new App();
$app->run();