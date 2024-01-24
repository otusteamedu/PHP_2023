<?php

declare(strict_types=1);

use App\App;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../App/App.php';


$app = new App();
$app->run($argv);
