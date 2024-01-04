<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Klobkovsky\App\StringApplication;

$stringApp = new StringApplication();
echo $stringApp->run();
