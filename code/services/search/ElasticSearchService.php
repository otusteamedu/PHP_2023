<?php

/**
 * Класс для поиска в эластике
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

namespace Amedvedev\code\services\search;

use Amedvedev\code\config\Config;
use Amedvedev\code\presenters\ConsolePresenter;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class ElasticSearchService extends SearchService
{
    private readonly Client $client;
    private readonly ConsolePresenter $presenter;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([Config::get('elastic_container') . ':' . Config::get('elastic_local_port')])
            ->build();
        $this->presenter = new ConsolePresenter();
    }

    /**
     * Стратегия выбора метода
     * @param array $data
     * @param int $argc
     * @return void
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function strategy(array $data, int $argc): void
    {
        switch ($data[$argc - 1] ?? '') {
            case 'check':
                $this->check();
                break;
            case 'init':
                $this->init();
                break;
            case 'search':
                $this->search();
                break;
            default:
                $this->help();
        }
    }

    /**
     * Справка по коммандам
     * @return void
     */
    public function help(): void
    {
        echo PHP_EOL . 'Это консольное приложение для поиска по товарам. ' . PHP_EOL .
            'Команды для работы: ' . PHP_EOL .
            'init - для построения индекса' . PHP_EOL .
            'check - проверка соединения с сервисом поиска' . PHP_EOL .
            'параметры search - поиск' . PHP_EOL .
            'параметры: -tтекст -pцена -cкатегория' . PHP_EOL .
            'Пример команды: app.php check' . PHP_EOL .
            'Пример команды: app.php -tрыцори -p2000 -с"исторический роман"' . PHP_EOL . PHP_EOL;
    }

    /**
     * Метод проверки работоспособности сервиса поиска
     * @return void
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function check(): void
    {
        $response = $this->client->info();
        echo $response->getBody();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function init(): void
    {
        $filename = 'books.json';
        $file = file(Config::get('project_dir') . 'db/json/' . $filename);
        $params = [];
        //проверим наличие индекса
        foreach ($file as $string) {
            $json = json_decode($string, true);
            if (str_contains($string, 'create')) {
                $params['index'] = $json['create']['_index'];
                $params['id'] = $json['create']['_id'];
                continue;
            }

            if (str_contains($string, 'title')) {
                $params['body'] = $json;
                $this->client->index($params);
            }
        }

        echo 'Индекс создан' . PHP_EOL;
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(): void
    {
        $options = getopt('p::t::c::');
        //php /data/app.php -tрыцори search
        //php /data/app.php -tрыцори -p1000 search
        //php /data/app.php -tрыцори -p1000 -cдетектив search
        //php /data/app.php -tрыцори -p1000 -c"исторический роман" search
        //php /data/app.php -tрыцори -p1000 -cисторический search
        //php /data/app.php -tрыцори -cисторический search

        $must = [
            0 => [
                'match' => [
                    'title' => [
                        'query' => $options['t'] ?? '%',
                        'fuzziness' => 'auto',
                    ],
                ],
            ],
        ];

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
            'index' => 'otus-shop',
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

        $hits = $result->asArray()['hits']['hits'] ?? '';

        if (empty($hits)) {
            echo 'ничего не найдено';
            exit();
        }
        $this->presenter->showTextTable($hits);
    }
}
