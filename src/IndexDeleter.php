<?php

declare(strict_types=1);

namespace App;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class IndexDeleter
{
    public function __construct(private readonly ElasticSearchClient $elasticSearchClient)
    {
    }

    public function execute(string $indexName): void
    {
        try {
            $this->elasticSearchClient->getClient()->indices()->delete(['index' => $indexName]);
        } catch (ClientResponseException | MissingParameterException | ServerResponseException $e) {
            echo $e->getMessage();
        }
    }
}
