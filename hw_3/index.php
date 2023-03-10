<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$service =  new \Dgibadullin\Otus\StringService();
$app = new \Dgibadullin\Otus\App($service);
$app->run();