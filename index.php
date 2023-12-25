<?php

declare(strict_types=1);

use HW11\Elastic\ConsoleParameters;

require_once DIR . '/vendor/autoload.php';

$app = new HW11\Elastic\SearchExecutor('https://localhost:9200', 'elastic', 'pass1234');

$consoleParams = new ConsoleParameters(getopt('s:c:p:q:'));

$searchTerm = $consoleParams->getSearchTerm();
$category = $consoleParams->getCategory();
$price = $consoleParams->getPrice();
$stockQuantity = $consoleParams->getStockQuantity();

$searchResults = $app->search([
    'title' => $searchTerm,
    'category' => $category,
    'price' => $price,
    'stock' => $stockQuantity,
]);

$table = new LucidFrame\Console\ConsoleTable();
$table->setHeaders(['#', 'title', 'sku', 'category', 'price', 'stocks']);

foreach ($searchResults['hits'] as $key => $hit) {
    $data = $hit['_source'];
    $stockInline = '';
    foreach ($data['stock'] as $stock) {
        $stockInline .= "{$stock['shop']} {$stock['stock']} шт.; ";
    }
    $table->addRow([$key, $data['title'], $data['sku'], $data['category'], $data['price'], $stockInline]);
}
$table->setIndent(4)->display();
