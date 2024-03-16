<?php

declare(strict_types=1);

use Symfony\Component\Console\Application as ConsoleApplication;
use Yalanskiy\SearchApp\Application;
use Yalanskiy\SearchApp\Infrastructure\Command\LoadCommand;

require __DIR__ . '/vendor/autoload.php';

const APP_ROOT = __DIR__;

define("ELASTIC_SERVER", $_ENV['ELASTIC_SERVER'] ?? '');
define("ELASTIC_USERNAME", $_ENV['ELASTIC_USERNAME'] ?? '');
define("ELASTIC_PASSWORD", $_ENV['ELASTIC_PASSWORD'] ?? '');
define("ELASTIC_INDEX_NAME", $_ENV['ELASTIC_INDEX_NAME'] ?? '');

try {
    $application = new Application();
    $application->run();
} catch (Exception $exeption) {
    echo $exeption->getMessage();
}
