<?php

declare(strict_types=1);

namespace App\Service;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class IndexDeleter extends ElasticServiceTemplate
{
    public function execute(string $indexName): void
    {
        try {
            $this->client->indices()->delete(['index' => $indexName]);
        } catch (ClientResponseException|MissingParameterException|ServerResponseException $e) {
            echo $e->getMessage();
        }
    }
}
