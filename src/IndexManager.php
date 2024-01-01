<?php

namespace DanielPalm\Library;

use Elastic\Elasticsearch\Client;

class IndexManager
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function findHistoricalNovelsUnder2000WithStock($titleFirst, $titleSecond)
    {
        $params = [
            'index' => 'otus-shop',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'fuzzy' => [
                                    'title' => [
                                        'value' => $titleFirst,
                                        'fuzziness' => 'AUTO' // Уровень "fuzziness"
                                    ]
                                ]
                            ],
                            [
                                'match' => ['category' => 'Исторический роман']
                            ],
                            [
                                'range' => ['price' => ['lt' => 2000]]
                            ]
                        ],
                        'should' => [
                            [
                                'fuzzy' => [
                                    'title' => [
                                        'value' => $titleSecond,
                                        'fuzziness' => 'AUTO' // Уровень "fuzziness"
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);

        $documents = [];

        if (isset($response['hits']['hits'])) {
            foreach ($response['hits']['hits'] as $hit) {
                $doc = $hit['_source'];
                $doc['_score'] = $hit['_score'];
                $documents[] = $doc;
            }
        }

        return $documents;
    }



}