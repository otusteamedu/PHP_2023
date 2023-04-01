<?php

declare(strict_types=1);

use Vp\App\App;
use Vp\App\Config;
use Vp\App\Services\CommandProcessor;

require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = Config::getInstance()
    ->setUser($_ENV['ELASTIC_USER'])
    ->setPassword($_ENV['ELASTIC_PASSWORD'])
    ->setPort($_ENV['ELASTIC_PORT'])
    ->setPath(__DIR__ . $_ENV['ELASTIC_BULK'])
    ->setIndexName($_ENV['INDEX_NAME'])
    ->setSize($_ENV['RETURN_SIZE']);

try {
    $app = new App(new CommandProcessor());
    $app->run($_SERVER['argv']);
} catch (Exception $e) {
    fwrite(STDERR, "Error: " . $e->getMessage() . PHP_EOL);
}
