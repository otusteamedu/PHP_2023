<?php

namespace src;

require __DIR__ . '/../vendor/autoload.php';

use src\application\AppPHPAndDataBase;

$app = new AppPHPAndDataBase();
$app->run();
