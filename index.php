<?php

require 'vendor/autoload.php';

use Daniel\Pattern\App;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = isset($_GET['pageSize']) ? (int)$_GET['pageSize'] : 10;

$app = new App();
$result = $app->run($page, $pageSize);

print_r($result);
