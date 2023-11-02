<?php

/**
 * Система хранения ElasticSearch
 * php version 8.2.8
 *
 * @category ItIsDepricated
 * @package  AmedvedevPHP2023Otus
 * @author   Alex 150Rus <alex150rus@outlook.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @Version  GIT: 1.0.0
 * @link     http://github.com/Alex150Rus My_GIT_profile
 */

declare(strict_types=1);

namespace Amedvedev\code\applications\elastic\storages;

use Amedvedev\code\config\Config;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Psr\Http\Message\StreamInterface;

class ElasticStorage extends Storage
{
    private readonly Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([Config::get('elastic_container') . ':' . Config::get('elastic_local_port')])
            ->build();
    }

    /**
     * @param array $array
     * @return bool
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function save(array $array): bool
    {
        $params = [];
        $params['index'] = $array['index'];
        $params['id'] = $array['id'];
        unset($array['index'], $array['id']);
        $params['body'] = $array;
        $this->client->index($params);
        return true;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function info(): StreamInterface
    {
        $response = $this->client->info();
        return $response->getBody();
    }

    /**
     * @param array $options
     * @return array|mixed
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(array $options): mixed
    {

        if (empty($options['i'])) {
            return [];
        }

        $must = [];

        if (!empty($options['t'])) {
            $must[] = [
                'match' => [
                    'title' => [
                        'query' => $options['t'],
                        'fuzziness' => 'auto',
                    ],
                ]
            ];
        }

        if (!empty($options['c'])) {
            $must[] = [
                'match' => [
                    'category' => [
                        'query' => $options['c'],
                        'fuzziness' => 'auto',
                    ],
                ],
            ];
        }

        $params = [
            'index' => $options['i'],
            'size' => 100,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => $must,
                    ]
                ]
            ]
        ];

        if (!empty($options['p'])) {
            $params['body']['query']['bool']['filter'] = [
                'range' => [
                    'price' => [
                        'lt' => $options['p']
                    ]
                ]
            ];
        }

        $result = $this->client->search($params);

        return $result->asArray()['hits']['hits'] ?? [];
    }
}
