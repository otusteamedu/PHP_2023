<?php

declare(strict_types=1);

namespace Gesparo\ES\Command;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Gesparo\ES\Service\CreateIndexService;

class CreateIndexCommand extends BaseCommand
{
    private CreateIndexService $createIndexService;

    public function __construct(CreateIndexService $createIndexService)
    {
        parent::__construct();

        $this->createIndexService = $createIndexService;
    }

    /**
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function run(): void
    {
        $this->createIndexService->createIndex();

        $this->outputHelper->success('Index was successfully deleted');
    }
}
