<?php

declare(strict_types=1);

include_once __DIR__ . '/vendor/autoload.php';

use DimAl\Homework5\Application\App;

$app = new App();
//$app->run();
$list = $app->checkEmailsFromFile(__DIR__ . '/testemails.txt');
echo "<pre>";
foreach ($list as $l) {
    echo "$l[email] => $l[status]\r\n";
}
