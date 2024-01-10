<?php

declare(strict_types=1);

use src\Application\UseCase\SearchUseCase;
use src\Infrastructure\Repositories\BookRepository;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Application/UseCase/SearchUseCase.php';
require __DIR__ . '/../src/Infrastructure/Repositories/BookRepository.php';

$useCase = new SearchUseCase(new BookRepository());

$values = getopt('t:c:p:');

$response = $useCase(
    title: $values['t'],
    category: $values['c'],
    price: $values['p']
);

print_r($response['hits']['hits']);
