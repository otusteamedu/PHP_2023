<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\SelectQueryBuilder;

$queryBuilder = new SelectQueryBuilder();
$result = $queryBuilder
    ->from('clients')
    ->execute();


//var_dump($result);

foreach ($result as $k => $item) {
    var_dump($item);
}


