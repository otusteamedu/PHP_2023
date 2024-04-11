<?php

namespace App;

use App\Service\ElasticsearchService;
use App\Dto\SearchDto;

class SearchApp
{
    public function executeCommand(array $arguments)
    {
        // Создание объекта SearchDto
        $searchDto = new SearchDto($arguments);

        // Вызов ElasticsearchService
        $searchService = new ElasticsearchService();
        $searchService->executeCommand($searchDto);

    }
}
