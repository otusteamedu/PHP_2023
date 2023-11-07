<?php

declare(strict_types=1);

namespace Gesparo\ES\Command;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Gesparo\ES\Service\SearchService;

class SearchCommand extends BaseCommand
{
    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        parent::__construct();

        $this->searchService = $searchService;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function run(): void
    {
        $this->searchService->makeSearch();
    }
}
