<?php

declare(strict_types=1);

use Santonov\Otus\Application;

require_once '../vendor/autoload.php';

$app = new Application();
$response = $app->process();
echo $response->getMessage();
