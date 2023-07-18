<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw11\YoutubeChannelAnalyzer;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearchConnection
{
    protected $elasticConnection;

    public function __construct()
    {
        $this->elasticConnection = ClientBuilder::create()
        ->setHosts(['http://hw11-elasticsearch:9200'])
        ->build();
    }

    public function searchDocument(string $indexName, array $arQueryParams): array
    {
        return $this->elasticConnection->search(
            [
                'index' => $indexName,
                'body'  => $arQueryParams
            ]
        )->asArray();
    }

    public function addDocument(string $indexName, string $docId, array $docParams): void
    {
        $this->elasticConnection->index(
            [
                'index' => $indexName,
                'id'    => $docId,
                'body'  => $docParams
            ]
        );
    }

    public function updateDocument(string $indexName, string $docId, array $docParams): void
    {
        $this->elasticConnection->update(
            [
                'index' => $indexName,
                'id'    => $docId,
                'body'  => [
                    'doc' => $docParams
                ]
            ]
        );
    }

    public function deleteDocument(string $indexName, string $docId): void
    {
        $this->elasticConnection->delete(
            [
                'index' => $indexName,
                'id'  => $docId
            ]
        );
    }

    public function createIndex(string $indexName, array $mappings): void
    {
        $this->elasticConnection->indices()->create(
            [
                'index' => $indexName,
                'body' => [
                    'mappings' => [
                        'properties' => $mappings,
                    ]
                ]
            ]
        );
    }

    public function deleteIndex(string $indexName): void
    {
        $this->elasticConnection->indices()->delete(
            [
                'index' => $indexName
            ]
        );
    }
}
