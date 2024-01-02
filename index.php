<?php

require 'vendor/autoload.php';

use DanielPalm\Library\App;

$app = new App();
$result = $app->run($argv);

print_r($result);
