<?php

require __DIR__ . '/vendor/autoload.php';

use App\CliCommand\CreateDefaultDocumentsCommand;
use App\CliCommand\CreateDefaultIndexCommand;
use App\CliCommand\DeleteDefaultIndexCommand;
use App\CliCommand\SearchBooksCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new SearchBooksCommand());
$application->add(new CreateDefaultIndexCommand());
$application->add(new DeleteDefaultIndexCommand());
$application->add(new CreateDefaultDocumentsCommand());

try {
    $application->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
