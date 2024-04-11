<?php

use App\Dto\SearchDto;
use App\SearchApp;
use App\Service\ElasticsearchService;

require __DIR__ . '/vendor/autoload.php';

try {

    $searchApp = new SearchApp();
    $searchApp->executeCommand($argv);

} catch (\Exception $e) {
    echo 'Произошла ошибка при выполнении программы!' . PHP_EOL .
        'Текст ошибки: ' . $e->getMessage() . PHP_EOL .
        $e->getTraceAsString();
}

