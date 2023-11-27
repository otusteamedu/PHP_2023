<?php
declare(strict_types=1);

require_once __DIR__ .'/../vendor/autoload.php';
require_once __DIR__ .'/../src/app.php';

use Elena\hw5\App;

$app = new App();
echo $app->run();



