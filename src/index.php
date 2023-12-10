<?php
declare(strict_types=1);

require_once realpath(__DIR__ . '/vendor/autoload.php');

use Ekovalev\Otus\App;

$app = new App();
$app->run();