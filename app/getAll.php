<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

use DEsaulenko\Hw13\DB\Connector;
use DEsaulenko\Hw13\Product\ProductMapper;
use Dotenv\Dotenv;

try {
    Dotenv::createUnsafeImmutable(__DIR__)->load();
    $pdo = Connector::getInstance()->getPDO();

    $productMapper = new ProductMapper($pdo);
    $products = $productMapper->findAll();
    dump($products);
} catch (Exception $e) {
    dump($e);
}
