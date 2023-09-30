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

    private string $bulkFileData;

    private string $url;

    /** @var string  */
    private const DEFAULT_USER = 'elastic';

    /** @var string[]  */
    private const OPERATIONS = [
        '>=' => 'gte',
        '<=' => 'lte'
    ];

    /**
     * @throws AuthenticationException
     */
    public function __construct(
        string $config = 'config_index_es.php',
        string $bulkFileData = "books.json",
        string $url = 'http://localhost:9200'
    ) {
        $this->params = require_once __DIR__ . "/../config/{$config}";
        $this->url = $url;

        $env = parse_ini_file(__DIR__ . '/../.env');
        $this->client = ClientBuilder::create()
            ->setHosts([$url])
            ->setBasicAuthentication(self::DEFAULT_USER, $env['ELASTIC_PASSWORD'])
            ->build();
        $this->bulkFileData = $bulkFileData;
    }

    /**
     * @return void
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     * @throws Exception
     */
    public function init(): void
    {
        $response = $this->client->indices()->exists(['index' => $this->params['index']]);

        if ($response->getStatusCode() != 200) {
            $this->client->indices()->create($this->params);
            $this->bulkLoadData();
        }
    }

    /**
     * @throws Exception
     */
    private function bulkLoadData(): void
    {
        if (file_exists(__DIR__ . "/../{$this->bulkFileData}")) {
            shell_exec("curl --location --request POST '{$this->url}/_bulk' --header 'Content-Type: application/json' --data-binary '@{$this->bulkFileData}'");
        } else {
            throw new Exception("File {$this->bulkFileData} not found");
        }
    }

    /**
     * @return array
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws Exception
     */
    public function search(): array
    {
        $args = $_SERVER['argv'];
        unset($args[0]);
        $countArgv = count($args);

        $params = [
            'index' => $this->params['index'],
            'body'  => []
        ];

        switch ($countArgv) {
            // Поиск по title
            // php public/index.php гроницы
            case 1:
                $query = $this->searchArg1($args[1]);
                break;

            // Поиск по title и строгому соответствую категории category
            // php public/index.php гроницы "Любовный роман"
            case 2:
                $query = $this->searchArg2($args[1], $args[2]);
                break;

            // Поиск по title, строгому соответствую категории category и ценой <=|>= указанной
            // php public/index.php гроницы "Любовный роман" \>=9700
            case 3:
                $query = $this->searchArg3($args[1], $args[2], $args[3]);
                break;

            // php public/index.php Штирлиц "Исторический роман" \>=700 1
            // последний аргумент может быть любым
            case 4:
                $query = $this->searchArg4($args[1], $args[2], $args[3], $args[4]);
                break;

            default:
                throw new Exception("Incorrect args");
        }

        $params['body']['query'] = $query;
        $results = $this->client->search($params)->asArray();

        if (!empty($results['hits']['hits'])) {
            $results = array_map(function ($item) {
                return $item['_source'];
            }, $results['hits']['hits']);
        } else {
            $results = [];
        }

        return $results;
    }

    private function searchArg1(string $query): array
    {
        return [
            "match" => [
                "title" => [
                    "query" => $query,
                    "fuzziness" => "auto"
                ]
            ]
        ];
    }

    private function searchArg2(string $query1, string $query2): array
    {
        return [
            "bool" => [
                "must" => [
                    $this->searchArg1($query1)
                ],
                "filter" => [
                    "term" => [
                        "category" => $query2
                    ]
                ]
            ]
        ];
    }

    private function searchArg3(string $query1, string $query2, string $query3): array
    {
        $operation = self::OPERATIONS[substr($query3, 0, 2)];

        return [
            "bool" => [
                "must" => [
                    $this->searchArg1($query1)
                ],
                "filter" => [
                    [
                        "term" => [
                            "category" => $query2
                        ]
                    ],
                    [
                        "range" => [
                            "price" => [
                                $operation => substr($query3, 2)
                            ]
                        ]
                    ]

                ]
            ]
        ];
    }

    private function searchArg4(string $query1, string $query2, string $query3): array
    {
        $result = $this->searchArg3($query1, $query2, $query3);
        $result['bool']['filter'][] = [
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
        ];

        return $result;
    }
}
