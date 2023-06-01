<?php

declare(strict_types=1);

use Sekaiichi\SuperApp\Actions\SearchProductAction;

require __DIR__ . '/vendor/autoload.php';

$searchProduct = new SearchProductAction();

try {
    $products = $searchProduct('iphone');
    var_dump($products);
} catch (JsonException $e) {
    echo $e->getMessage();
}
