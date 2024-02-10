<?php

declare(strict_types=1);

use Yevgen87\App\Infrastructure\App;

require __DIR__ . '/vendor/autoload.php';

$app = new App();
echo $app->run();
