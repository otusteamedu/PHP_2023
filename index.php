<?php

require 'vendor/autoload.php';

use App\App;

$app = new App();
$result = $app->run($argv);

print_r($result);
