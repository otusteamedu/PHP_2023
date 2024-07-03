<?php

require '../../vendor/autoload.php';

include("../Src/App.php");

use App\Src\App;

header('Content-Type: application/json');
$app = new App();
echo $app->run();
