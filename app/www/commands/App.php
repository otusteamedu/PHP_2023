<?php

declare(strict_types=1);

namespace Commands;

use Ahc\Cli\Application;
use Commands\CreateCommand;
use Commands\CheckCommand;
use Commands\InsertCommand;
use Commands\SearchCommand;
use Commands\DeleteCommand;

class App
{
    public function run()
    {
        $app = new Application('App', 'v0.0.1');

        $app->add(new CreateCommand(), 'c');
        $app->add(new CheckCommand(), 'ch');
        $app->add(new InsertCommand(), 'i');
        $app->add(new SearchCommand(), 's');
        $app->add(new DeleteCommand(), 'd');

        $app->handle($_SERVER['argv']);
    }
}
