<?php

declare(strict_types=1);

namespace App;

use src\Application\UseCase\SearchUseCase;
use src\Infrastructure\Repositories\BookRepository;

require __DIR__ . '/../src/Application/UseCase/SearchUseCase.php';
require __DIR__ . '/../src/Infrastructure/Repositories/BookRepository.php';

class App
{
    public function run(): void
    {
        $useCase = new SearchUseCase(new BookRepository());

        $values = getopt('t:c:p:');

        $response = $useCase(
            title: $values['t'],
            category: $values['c'],
            price: $values['p']
        );

        print_r($response['hits']['hits']);
    }
}
