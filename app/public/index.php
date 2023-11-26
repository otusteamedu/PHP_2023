<?php

declare(strict_types=1);

require_once('../vendor/autoload.php');

use Artyom\Php2023\App;

$app = new App();
echo $app->run();
