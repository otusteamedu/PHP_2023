<?php

declare(strict_types=1);

use Symfony\Component\Console\Application;
use Yalanskiy\ActiveRecord\Commands\ArticlesFullCommand;
use Yalanskiy\ActiveRecord\Commands\ArticlesShortCommand;

require __DIR__ . '/vendor/autoload.php';

//use Symfony\Component\Console\Application;
//use PDO;
//use Yalanskiy\SearchApp\Commands\FindBookCommand;
//use Yalanskiy\SearchApp\Commands\LoadCommand;

define("POSTGRES_DATABASE", $_ENV['POSTGRES_DATABASE'] ?? '');
define("POSTGRES_USERNAME", $_ENV['POSTGRES_USERNAME'] ?? '');
define("POSTGRES_PASSWORD", $_ENV['POSTGRES_PASSWORD'] ?? '');

try {
    $pdo = new PDO('pgsql:dbname=' . POSTGRES_DATABASE . ';host=postgres', POSTGRES_USERNAME, POSTGRES_PASSWORD);


    $application = new Application('PDO ActiveRecord homework (13)', '1.0');
    $application->addCommands([
        new ArticlesShortCommand($pdo),
        new ArticlesFullCommand($pdo),
    ]);

    $application->run();
} catch (Exception $exeption) {
    echo $exeption->getMessage();
}
