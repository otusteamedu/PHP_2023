<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\IndexDeleteException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class IndexDeleter extends ElasticSearchCommonService
{
    /**
     * @throws IndexDeleteException
     */
    public function execute(string $indexName): void
    {
        try {
            $this->client->indices()->delete(['index' => $indexName]);
        } catch (ClientResponseException | MissingParameterException | ServerResponseException) {
            throw new IndexDeleteException();
        }
    }
}
