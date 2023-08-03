<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

try {
    $app = new \VLebedev\BookShop\App();
    $app->execute();
} catch (Exception $e) {
    echo $e->getMessage();
}
