<?php

use App\Dto\SearchDto;
use App\Service\ElasticsearchService;

require __DIR__ . '/vendor/autoload.php';

try {

    $searchDto = new SearchDto($argv);
    $searchBooks = new ElasticsearchService();
    $searchBooks->executeCommand($searchDto);

} catch (\Exception $e) {
    echo 'Произошла ошибка при выполнении программы!' . PHP_EOL .
        'Текст ошибки: ' . $e->getMessage() . PHP_EOL .
        $e->getTraceAsString();
}

