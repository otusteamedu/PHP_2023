<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use YuzyukRoman\App\App;

$app = new App('string', 'Everything is OK', 'Everything is BAD');
$app->start();
