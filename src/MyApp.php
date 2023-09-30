<?php

namespace App;

use Elastic\Elasticsearch\{ClientBuilder,
    Client,
    Exception\AuthenticationException,
    Exception\ClientResponseException,
    Exception\MissingParameterException,
    Exception\ServerResponseException};
use Exception;

class MyApp
{
    private Client $client;
    private array $params;

    public function __construct(Client $client, string $config = 'config_index_es.php')
    {
        $this->params = require_once __DIR__ . "/../config/{$config}";
        $this->client = $client;
    }

    /**
     * @return void
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     * @throws Exception
     */
    public function init(): void
    {
        if (!$this->issetIndex()) {
            $this->client->indices()->create($this->params);
            $this->bulkLoadData();
        }
    }

    /**
     * @throws Exception
     */
    private function bulkLoadData(): void
    {
        if (file_exists(__DIR__ . "/../books.json")) {
            `curl --location --request POST 'http://localhost:9200/_bulk' --header 'Content-Type: application/json' --data-binary "@books.json"`;
        } else {
            throw new Exception('File not found');
        }
    }

    public function getStatusClient(): bool
    {
        try {
            $response = $this->client->info();
        } catch (ServerResponseException | ClientResponseException $e) {
            return false;
        }

        return $response->getStatusCode() === 200;
    }

    /**
     * @throws Exception
     */
    public function issetIndex(): bool
    {
        if (!isset($this->params['index'])) {
            throw new Exception(' Incorrect configuration');
        }

        if ($this->getStatusClient()) {
            try {
                $params = ['index' => $this->params['index']];
                $response = $this->client->indices()->getSettings($params);
            } catch (ServerResponseException | ClientResponseException $e) {
                return false;
            }

            return $response->getStatusCode() === 200;
        }

        return false;
    }

    /**
     * @throws AuthenticationException
     */
    public static function createClientES(): Client
    {
        return ClientBuilder::create()
            ->setHosts(['http://localhost:9200'])
            ->setBasicAuthentication('elastic', 'pass')
            ->build();
    }

    public function search()
    {
        $args = $_SERVER['argv'];
        unset($args[0]);
        $countArgv = count($args);

        $params = [
            'index' => 'otus-shop',
            'body'  => []
        ];

        switch ($countArgv) {
            // Поиск по title
            // php public/index.php гроницы
            case 1:
                $query = [
                    "match" => [
                        "title" => [
                            "query" => $args[1],
                            "fuzziness" => "auto"
                        ]
                    ]
                ];
                break;

            // Поиск по title и строгому соответствую категории category
            // php public/index.php гроницы "Любовный роман"
            case 2:
                $query = [
                    "bool" => [
                        "must" => [
                            "match" => [
                                "title" => [
                                    "query" => $args[1],
                                    "fuzziness" => "auto"
                                ]
                            ]
                        ],
                        "filter" => [
                            "term" => [
                                "category" => $args[2]
                            ]
                        ]
                    ]
                ];
                break;

            // Поиск по title, строгому соответствую категории category и ценой <|<=|>= указанной
            // php public/index.php гроницы "Любовный роман" \>=9700
            case 3:
                $operations = [
                    '>=' => 'gte',
                    '<=' => 'lte'
                ];
                $operation = $operations[substr($args[3], 0, 2)];

                $query = [
                    "bool" => [
                        "must" => [
                            "match" => [
                                "title" => [
                                    "query" => $args[1],
                                    "fuzziness" => "auto"
                                ]
                            ]
                        ],
                        "filter" => [
                            [
                                "term" => [
                                    "category" => $args[2]
                                ]
                            ],
                            [
                                "range" => [
                                    "price" => [
                                        $operation => substr($args[3], 2)
                                    ]
                                ]
                            ]

                        ]
                    ]
                ];
                break;

            //  php public/index.php Штирлиц "Исторический роман" \>=700 1
            case 4:
                $operations = [
                    '>=' => 'gte',
                    '<=' => 'lte'
                ];
                $operation = $operations[substr($args[3], 0, 2)];

                $query = [
                    "bool" => [
                        "must" => [
                            "match" => [
                                "title" => [
                                    "query" => $args[1],
                                    "fuzziness" => "auto"
                                ]
                            ]
                        ],
                        "filter" => [
                            [
                                "term" => [
                                    "category" => $args[2]
                                ]
                            ],
                            [
                                "range" => [
                                    "price" => [
                                        $operation => substr($args[3], 2)
                                    ],
                                ]
                            ],
                            [
                                "nested" => [
                                    "path" => "stock",
                                    "query" => [
                                        "range" => [
                                            "stock.stock" => [
                                                "gte" => 1
                                            ]
                                        ]
                                    ]

                                ]

                            ]
                        ]
                    ]
                ];

                break;

        }

        $params['body']['query'] = $query;
        $results = $this->client->search($params);

        print_r($results['hits']);
    }
}
