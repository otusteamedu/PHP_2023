<?php

declare(strict_types=1);

namespace Chernomordov\App;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

class ElasticsearchService
{
    private Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct(string $userName, string $password)
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['https://elasticsearch:9200'])
            ->setBasicAuthentication($userName, $password)
            ->setSSLVerification(false)
            ->build();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(array $searchParams): Elasticsearch|Promise
    {
        return $this->client->search($searchParams);
    }

    /**
     * @param string $indexName
     * @param array $indexSettings
     * @return void
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function createIndex(string $indexName, array $indexSettings): void
    {
        if ($this->isIndexExists($indexName)) {
            return;
        }

        $params = [
            'index' => $indexName,
            'body' => $indexSettings,
        ];

        $this->client->indices()->create($params);
    }

    /**
     * @param string $filePath
     * @param string $indexName
     * @return void
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function setDataBulk(string $filePath, string $indexName): void
    {
        if (!$this->isIndexExists($indexName)) {
            return;
        }

        $bulkData = file_get_contents($filePath);
        $actions = explode("\n", $bulkData);

        $formattedBulk = [];

        foreach ($actions as $action) {
            if (empty(trim($action))) {
                continue;
            }
            $jsonAction = json_decode($action, true);

            $formattedBulk[] = ['index' => ['_index' => $indexName]];
            $formattedBulk[] = $jsonAction;
        }

        $this->client->bulk(['body' => $formattedBulk]);
    }

    /**
     * @param string $indexName
     * @return bool
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    private function isIndexExists(string $indexName): bool
    {
        return $this->client->indices()->exists(['index' => $indexName])->getStatusCode() === 200;
    }

    /**
     * @param string $indexName
     * @return void
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function deleteIndex(string $indexName): void
    {
        $this->client->indices()->delete(['index' => $indexName]);
    }

    /**
     * @param $body
     * @return Elasticsearch|Promise
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function scroll($body): Elasticsearch|Promise
    {
        return $this->client->scroll($body);
    }
}
