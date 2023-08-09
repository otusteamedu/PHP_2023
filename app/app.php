<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

use DEsaulenko\Hw12\App\App;
use DEsaulenko\Hw12\Constants;
use DEsaulenko\Hw12\Controller\RedisController;
use DEsaulenko\Hw12\Storage\RedisStorage;
use Dotenv\Dotenv;

try {
    Dotenv::createUnsafeImmutable(__DIR__)->load();
    $typeStorage = getenv(Constants::DEFAULT_STORAGE);
    switch ($typeStorage) {
        case Constants::STORAGE_REDIS:
            $storage = new RedisStorage();
            $controller = new RedisController($storage);
            break;
        default:
            throw new \Exception(Constants::NO_DEFAULT_STORAGE);
    }
    $app = new App($controller);
    $app->run();
} catch (Exception $e) {
    dump($e);
}
