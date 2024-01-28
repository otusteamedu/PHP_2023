<?php

require 'vendor/autoload.php';

use Daniel\Pattern\App;

$lastId = isset($_GET['lastId']) ? (int)$_GET['lastId'] : null;
$pageSize = isset($_GET['pageSize']) ? (int)$_GET['pageSize'] : 10;

$app = new App();
$result = $app->run($lastId, $pageSize);

print_r($result);
