#!/usr/local/bin/php
<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/helpers.php';

// Run app
$app = new Common\Application\ConsoleApp(
    container(),
    config()
);

$logger = container()->get(\Psr\Log\LoggerInterface::class);
$logger->info('Console app started');

$app->run();
