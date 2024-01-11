<?php

declare(strict_types=1);

use Santonov\Otus\Application;

require_once '../vendor/autoload.php';

$app = new Application();
$result = $app->process();
echo implode("<br>", $result);
