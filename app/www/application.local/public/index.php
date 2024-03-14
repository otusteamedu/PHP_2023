<?php

declare(strict_types=1);

use AYamaliev\hw11\Application\Dto\SearchDto;
use AYamaliev\hw11\Application\UseCase\SearchBooks;
use AYamaliev\hw11\Infrastructure\Repository\ElasticSearchRepository;

require __DIR__ . '/../vendor/autoload.php';

try {
    $client = new ElasticSearchRepository();
    $searchDto = new SearchDto($argv);

    ((new SearchBooks($client))($searchDto));
} catch (\Exception $e) {
    echo $e->getMessage();
}
