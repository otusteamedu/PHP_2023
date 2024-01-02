<?php

namespace DanielPalm\Library;

use Elastic\Elasticsearch\ClientInterface;

class IndexManager
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function findNovelsWithOptionalParameters($parameters)
    {
        $params = [
            'index' => $parameters['index'],
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [],
                        'should' => []
                    ]
                ]
            ]
        ];

        if (!empty($parameters['titleFirst'])) {
            $params['body']['query']['bool']['must'][] = [
                'fuzzy' => [
                    'title' => [
                        'value' => $parameters['titleFirst'],
                        'fuzziness' => 'AUTO'
                    ]
                ]
            ];
        }

        if (!empty($parameters['titleSecond'])) {
            $params['body']['query']['bool']['should'][] = [
                'fuzzy' => [
                    'title' => [
                        'value' => $parameters['titleSecond'],
                        'fuzziness' => 'AUTO'
                    ]
                ]
            ];
        }

        if (!empty($parameters['category'])) {
            $params['body']['query']['bool']['must'][] = [
                'match' => ['category' => $parameters['category']]
            ];
        }

        if (!empty($parameters['price'])) {
            $params['body']['query']['bool']['must'][] = [
                'range' => ['price' => ['lt' => $parameters['price']]]
            ];
        }

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
