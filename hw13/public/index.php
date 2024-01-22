<?php
declare(strict_types=1);

use elena\hw13\app;

require_once __DIR__ .'/../vendor/autoload.php';
require_once __DIR__ .'/../src/app.php';

$app = new App();
echo $app->run();

