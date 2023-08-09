<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

use DEsaulenko\Hw13\DB\Connector;
use DEsaulenko\Hw13\DiscountPrice\DiscountPrice;
use DEsaulenko\Hw13\Product\ProductMapper;
use Dotenv\Dotenv;

$categories = [
    'category1',
    'category2',
    'category3',
    'category4',
    'category5',
];

for ($i = 0; $i < 10; $i++) {
    $price = (float)random_int(500, 10000);
    $products[] = [
        'name' => md5(serialize(rand(1, 9999999))),
        'description' => md5(serialize(rand(1, 9999999))),
        'price' => $price,
        'category' => $categories[random_int(0, 4)]
    ];
    $prices[] = [
        'product_id' => $i + 1,
        'discount_price' => $price * 0.95
    ];
}

try {
    Dotenv::createUnsafeImmutable(__DIR__)->load();
    $pdo = Connector::getInstance()->getPDO();

    $productMapper = new ProductMapper($pdo);
    foreach ($products as $product) {
        $p = $productMapper->insert($product);
    }

    $discountPrice = new DiscountPrice($pdo);
    foreach ($prices as $price) {
        $p = $discountPrice->insert($price);
    }
} catch (Exception $e) {
    dump($e);
}
