<?php

declare(strict_types=1);

use Dgibadullin\Otus\App;
use Dgibadullin\Otus\StringService;

require __DIR__ . '/vendor/autoload.php';

$service =  new StringService();
$app = new App($service);
$app->run();
