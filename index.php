<?php

require __DIR__ . '/vendor/autoload.php';

use App\Command\CreateDefaultDocumentsCommand;
use App\Command\CreateDefaultIndexCommand;
use App\Command\DeleteDefaultIndexCommand;
use App\Command\SearchBooksCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new SearchBooksCommand());
$application->add(new CreateDefaultIndexCommand());
$application->add(new DeleteDefaultIndexCommand());
$application->add(new CreateDefaultDocumentsCommand());

$application->run();
