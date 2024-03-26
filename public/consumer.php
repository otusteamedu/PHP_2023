<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Rabbit\Daniel\Consumer\Consumer;

$consumer = new Consumer();
$consumer->consume();