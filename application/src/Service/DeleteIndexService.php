<?php

declare(strict_types=1);

namespace Gesparo\ES\Service;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class DeleteIndexService
{
    private Client $elasticClient;
    private string $index;

    public function __construct(Client $elasticClient, string $index)
    {
        $this->elasticClient = $elasticClient;
        $this->index = $index;
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function deleteIndex(): void
    {
        if (!$this->isIndexExists()) {
            return;
        }

        $this->makeDeleteIndexRequest();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    private function isIndexExists(): bool
    {
        return $this->elasticClient->indices()->exists(['index' => $this->index])->asBool();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    private function makeDeleteIndexRequest(): void
    {
        $this->elasticClient->indices()->delete(['index' => $this->index]);
    }
}