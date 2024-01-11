<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Yalanskiy\SearchApp\Commands\FindBookCommand;
use Yalanskiy\SearchApp\Commands\LoadCommand;
use Yalanskiy\SearchApp\ElasticService;

const APP_ROOT = __DIR__;

define("ELASTIC_SERVER", $_ENV['ELASTIC_SERVER'] ?? '');
define("ELASTIC_USERNAME", $_ENV['ELASTIC_USERNAME'] ?? '');
define("ELASTIC_PASSWORD", $_ENV['ELASTIC_PASSWORD'] ?? '');

try {
    $service = new ElasticService(ELASTIC_SERVER, ELASTIC_USERNAME, ELASTIC_PASSWORD);

    $application = new Application('ElasticSearch homework (11)', '1.0');
    $application->addCommands([
        new LoadCommand($service),
        new FindBookCommand($service),
    ]);

    $application->run();
} catch (Exception $exeption) {
    echo $exeption->getMessage();
}
