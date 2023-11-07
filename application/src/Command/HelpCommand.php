<?php

declare(strict_types=1);

namespace Gesparo\ES\Command;

class HelpCommand extends BaseCommand
{
    public function run(): void
    {
        $this->outputHelper->error('You didn\'t specify a command. Please use one of the following:');

        $this->outputHelper->emptyLine();

        $this->outputHelper->info('php console.php create-index - to create the elastic index');
        $this->outputHelper->info('php console.php delete-index - to delete the elastic index');
        $this->outputHelper->info('php console.php bulk - to initialize the index with data');
        $this->outputHelper->info('php console.php search [price] [\'word\'] - to search for data in the index');
    }
}
