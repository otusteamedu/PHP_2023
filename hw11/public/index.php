<?php
declare(strict_types=1);

use Elena\Hw11\App;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/app.php';

$app = new App($argv);
echo $app->run($argv);

