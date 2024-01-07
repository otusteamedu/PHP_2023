<?php

declare(strict_types=1);

namespace Commands;

use Ahc\Cli\Input\Command;
use App\Elasticsearch\DeleteIndexAction;
use Models\BookStoreModel;

class DeleteCommand extends Command
{
    public function __construct()
    {
        parent::__construct('Delete', 'Delete Index');
    }


    public function execute($query)
    {
        $io = $this->app()->io();

        $delete = new DeleteIndexAction(BookStoreModel::INDEX_NAME);
        $delete->do();

        if ($delete->error) {
            $io->errorBold($delete->error . PHP_EOL);
            exit();
        }
        $io->boldGreen($delete->getMessage(), true);
        exit();
    }
}
