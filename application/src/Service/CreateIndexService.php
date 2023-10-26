<?php

declare(strict_types=1);

namespace Gesparo\ES\Service;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class CreateIndexService
{
    private Client $elasticClient;
    private string $index;

    public function __construct(Client $elasticClient, string $index)
    {
        $this->elasticClient = $elasticClient;
        $this->index = $index;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function createIndex(): void
    {
        $this->elasticClient->indices()->create($this->getParams());
    }

    private function getParams(): array
    {
        return [
            'index' => $this->index,
            'body' => [
                "settings" => [
                    "analysis" => [
                        "filter" => [
                            "russian_stop" => [
                                "type" => "stop",
                                "stopwords" => "_russian_"
                            ],
                            "russian_stemmer" => [
                                "type" => "stemmer",
                                "language" => "russian"
                            ]
                        ],
                        "analyzer" => [
                            "rebuilt_russian" => [
                                "tokenizer" => "standard",
                                "filter" => [
                                    "lowercase",
                                    "russian_stop",
                                    "russian_stemmer"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
