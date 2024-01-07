<?php

declare(strict_types=1);

namespace Commands;

use Ahc\Cli\Input\Command;
use App\Elasticsearch\CreateIndexAction;

class CreateCommand extends Command
{
    public function __construct()
    {
        parent::__construct('Create', 'Create Index');
    }

    public function execute()
    {
        $io = $this->app()->io();
        $create = new CreateIndexAction();
        $create->do();

        if ($create->error) {
            $io->errorBold($create->error . PHP_EOL);
            exit();
        }
        $io->boldGreen($create->getMessage(), true);
        exit();
    }
}
