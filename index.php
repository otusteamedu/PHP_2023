<?php

require 'vendor/autoload.php';

use Daniel\Pattern\App;

$app = new App();
$result = $app->run();

print_r($result);
