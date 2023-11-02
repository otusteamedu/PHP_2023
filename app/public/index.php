<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Publisher\Publisher;
use App\Infrastructure\QueryBuilder\SelectQueryBuilder;
use App\Infrastructure\Subscriber\HelperService;

try {
    $helper = new HelperService();
    $publisher = new Publisher();
    $publisher->subscribe($helper);

    $queryBuilder = new SelectQueryBuilder($publisher);
    $result = $queryBuilder
        ->from('clients')
        ->orderBy('middle_name', 'ASC')
        ->where('first_name', 'test2')
        ->execute();

    foreach ($result as $item) {
        var_dump($item);
    }
} catch (Exception $e) {
    print_r($e->getMessage());
}
