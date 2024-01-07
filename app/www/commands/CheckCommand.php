<?php

declare(strict_types=1);

namespace Commands;

use Ahc\Cli\Input\Command;
use App\Elasticsearch\Client;

class CheckCommand extends Command
{
    public function __construct()
    {
        parent::__construct('Check', 'Check connection');
    }

    public function execute()
    {
        $io = $this->app()->io();

        $client = Client::connect();
        $io->write($client->info(), true);
    }
}
