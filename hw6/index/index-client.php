<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

$process = 'client';
$app = new Elena\Hw6\App();
$app->run($process);
