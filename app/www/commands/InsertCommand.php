<?php

declare(strict_types=1);

namespace Commands;

use Ahc\Cli\Input\Command;
use App\Elasticsearch\BulkAction;
use Models\BookStoreModel;

class InsertCommand extends Command
{
    public function __construct()
    {
        parent::__construct('Insert', 'Parse JSON file and insert bulk data');
    }

    public function execute()
    {
        $io = $this->app()->io();
        $file_name = BookStoreModel::FILE_NAME;

        $file_dir = __DIR__ . '/../db/';
        if (!file_exists($file_dir . $file_name)) {
            $io->errorBold('File [' . $file_name . '] Not Found!' . PHP_EOL);
            exit();
        }

        $books = file_get_contents($file_dir . $file_name);

        $bulk = new BulkAction($books);
        $bulk->do();

        if ($bulk->error) {
            $io->errorBold($bulk->error . PHP_EOL);
            exit();
        }
        $io->boldGreen($bulk->getMessage(), true);
        exit();
    }
}
