<?php

require '../../vendor/autoload.php';

include("../Src/App.php");

use App\Src\App;

header('Content-Type: application/json');
$app = new App();
$result =  $app->run();
echo json_encode($result, JSON_UNESCAPED_UNICODE);
