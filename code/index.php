<?php

require __DIR__.'/vendor/autoload.php';

$service = new \Otus\Homework3\Service\BracketService();
$app = new \Otus\Homework3\App($service);
$app->run();