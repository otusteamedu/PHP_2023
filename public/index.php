<?php

declare(strict_types=1);

use App\AppValidator;

require __DIR__ . '/../vendor/autoload.php';

$app = new AppValidator();
$app->runApp();
