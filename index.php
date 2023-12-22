<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$app = new HW11\Elastic\ElasticSearch('https://localhost:9200', 'elastic', 'pass1234');

$getOpt = getopt('s:c:p:q:');

$arr = [];
if (isset($getOpt['s'])) {
    $arr['search'] = $getOpt['s'];
}

if (isset($getOpt['c'])) {
    $arr['category'] = $getOpt['c'];
}

if (isset($getOpt['p'])) {
    $arr['price'] = $getOpt['p'];
}

if (isset($getOpt['q'])) {
    $arr['stock'] = $getOpt['stock'];
}

$search = $app->search(['title' => 'рыцОри'])['hits'];
$total  = $search['total']['value'];


$table = new LucidFrame\Console\ConsoleTable();
$table->setHeaders(['#', 'title', 'sku', 'category', 'price', 'stocks']);

$stockInline = '';
foreach ($search['hits'] as $key => $hit) {
    $data = $hit['_source'];
    
    foreach ($data['stock'] as $stock) {
        $stockInline .= "{$stock['shop']} {$stock['stock']} шт.; ";
    }
    
    $table->addRow([$key, $data['title'], $data['sku'], $data['category'], $data['price'], $stockInline]);
    
    $stockInline = '';
}

$table->setIndent(4)->display();
