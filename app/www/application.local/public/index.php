<?php

declare(strict_types=1);

use AYamaliev\hw11\Application\UseCase\SearchBooks;
use AYamaliev\hw11\Infrastructure\Repository\ElasticSearchRepository;
use Elastic\Elasticsearch\ClientBuilder;

require __DIR__ . '/../vendor/autoload.php';

try {
    ((new SearchBooks())($argv));
} catch (\Exception $e) {
    echo $e->getMessage();
}
