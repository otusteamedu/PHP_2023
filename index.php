<?php

declare(strict_types=1);

use Sekaiichi\SuperApp\Actions\SearchProductAction;

require __DIR__ . '/vendor/autoload.php';

$searchProduct = new SearchProductAction();

try {
    $getData = json_decode($searchProduct('fefe'), true, 512, JSON_THROW_ON_ERROR);

    return ['message' => 'success', 'code' => 200, 'response' => $getData];

} catch (JsonException $e) {

    return ['message' => $e->getMessage(), 'code' => 500, 'response' => []];

}