<?php

declare(strict_types=1);

namespace Gesparo\ES\Command;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Gesparo\ES\Service\DeleteIndexService;

class DeleteIndexCommand extends BaseCommand
{
    private DeleteIndexService $deleteIndexService;

    public function __construct(DeleteIndexService $deleteIndexService)
    {
        parent::__construct();

        $this->deleteIndexService = $deleteIndexService;
    }

    /**
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function run(): void
    {
        $this->deleteIndexService->deleteIndex();

        $this->outputHelper->success('Index was successfully deleted');
    }
}
