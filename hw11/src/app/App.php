<?php

declare(strict_types=1);

namespace App;

use App\Services\PrepareOutputService;
use App\Services\PrepareSearchService;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class App
{
    use Helpers;

    private string $elasticHost;
    private string $elasticUsername;
    private string $elasticPassword;
    private string $elasticIndex;
    private string $elasticMaxOutputSize;

    private Client $client;

    public function __construct()
    {
        $this->elasticHost = $this->env('ELASTIC_HOST');
        $this->elasticUsername = $this->env('ELASTIC_USERNAME');
        $this->elasticPassword = $this->env('ELASTIC_PASSWORD');
        $this->elasticIndex = $this->env('ELASTIC_INDEX');
        $this->elasticMaxOutputSize = $this->env('ELASTIC_MAX_OUTPUT_SIZE');

        $client = ClientBuilder::create()
            ->setHosts([$this->elasticHost])
            ->setBasicAuthentication($this->elasticUsername, $this->elasticPassword)
            ->build();

        $this->client = $client;
    }

    public function get(): void
    {
        $searchParams = PrepareSearchService::getSearchParams();

        $params = [
            'index' => $this->elasticIndex,
            'size' => $this->elasticMaxOutputSize,
            'body' => [
                'sort' => [
                    "_score" => "desc"
                ],
                'query' => [
                    "bool" => $searchParams
                ]
            ]
        ];

        try {
            $result = $this->client->search($params);
        } catch (ClientResponseException | ServerResponseException $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        if (isset($result) && isset($result['hits']) && isset($result['hits']['hits'])) {
            $items = array_map(function ($item) {
                return $item['_source'];
            }, $result['hits']['hits']);

            PrepareOutputService::outputResult($items);
        }
    }

    public function create(): void
    {
        $params = [
            'index' => $this->elasticIndex,
            'body' => [
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256
                                ]
                            ]
                        ],
                        'sku' => [
                            'type' => 'keyword'
                        ],
                        'category' => [
                            'type' => 'keyword'
                        ],
                        'price' => [
                            'type' => 'short'
                        ],
                        'stock' => [
                            'properties' => [
                                'shop' => [
                                    'type' => 'keyword'
                                ],
                                'stock' => [
                                    'type' => 'short'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->client->indices()->create($params);

        $handle = fopen(realpath(__DIR__ . '/..') . '/books.json', "r");
        if ($handle) {
            $data = ['body' => []];
            $i = 0;

            while (($line = fgets($handle)) !== false) {
                $i++;

                $data['body'][] = json_decode($line, true);

                if ($i % 1000 == 0) {
                    $this->client->bulk($data);
                    $data = ['body' => []];
                }
            }

            if (!empty($data['body'])) {
                $this->client->bulk($data);
            }

            fclose($handle);
        }
    }
}
