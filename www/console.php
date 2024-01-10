<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Yalanskiy\SearchApp\Commands\FindCommand;
use Yalanskiy\SearchApp\Commands\LoadCommand;
use Yalanskiy\SearchApp\ElasticService;

const APP_ROOT = __DIR__;
const ELASTIC_SERVER = 'otus-elasticsearch';
const ELASTIC_USERNAME = 'elastic';
const ELASTIC_PASSWORD = 'elastic';

try {
    $service = new ElasticService(ELASTIC_SERVER, ELASTIC_USERNAME, ELASTIC_PASSWORD);

    $application = new Application('ElasticSearch homework (11)', '1.0');
    $application->addCommands([
        new LoadCommand($service),
        new FindCommand($service),
    ]);

    $application->run();
} catch (Exception $exeption) {
    echo $exeption->getMessage();
}
