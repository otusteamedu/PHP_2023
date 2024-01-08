<?php

declare(strict_types=1);

namespace Chernomordov\App;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CommandsService extends Command
{
    private ElasticsearchService $elasticClient;

    private array $indexSettings = [
        'mappings' => [
            'properties' => [
                'category' => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256,
                        ],
                    ],
                ],
                'price' => [
                    'type' => 'long',
                ],
                'sku' => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256,
                        ],
                    ],
                ],
                'stock' => [
                    'type' => 'nested',
                    'properties' => [
                        'shop' => [
                            'type' => 'text',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256,
                                ],
                            ],
                        ],
                        'stock' => [
                            'type' => 'long',
                        ],
                    ],
                ],
                'title' => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256,
                        ],
                    ],
                ],
            ],
        ],
    ];

    private array $searchParams = [
        'index' => 'otus-shop',
        'scroll' => '1m',
        'size' => 50,
        'track_total_hits' => true,
        'body' => [
            'query' => [
                'bool' => [
                    'must' => [],
                    'filter' => [
                        [
                            'nested' => [
                                'path' => 'stock',
                                'query' => [
                                    'bool' => [
                                        'must' => []
                                    ]
                                ]
                            ],
                        ]
                    ],
                ],
            ],
        ],
    ];

    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->elasticClient = new ElasticsearchService('elastic', '123456');
    }


    protected function configure(): void
    {
        $this
            ->setName('find:otus-shop')
            ->setHelp(
                "Доступные опции:\n--title 'Название книги'\n--category 'Название категории'\n--price='<=500' или -p'500'\n--stock='>=20' или -s'20'"
            )
            ->addOption('title', 't', InputOption::VALUE_OPTIONAL, 'Название книги')
            ->addOption('category', 'c', InputOption::VALUE_OPTIONAL, 'Категория')
            ->addOption('price', 'p', InputOption::VALUE_OPTIONAL, 'Цена вида >=100, 100, <=100')
            ->addOption('stock', 's', InputOption::VALUE_OPTIONAL, 'Остаток вида >=100, 100, <=100');
    }


    /**
     * @param $input
     * @param $output
     * @return int
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    protected function execute($input, $output): int
    {
        $this->elasticClient->createIndex('otus-shop', $this->indexSettings);

        $response = $this->find($input);

        $this->renderResult($response, $output);

        return Command::SUCCESS;
    }

    private function find(InputInterface $input): Elasticsearch|Promise
    {
        if ($title = $input->getOption('title')) {
            $this->setTitle($title);
        }

        if ($category = $input->getOption('category')) {
            $this->setCategory($category);
        }

        if ($price = $input->getOption('price')) {
            $this->setPrice($price);
        }

        if ($count = $input->getOption('stock')) {
            $this->setStock($count);
        }

        return $this->elasticClient->search($this->searchParams);
    }

    private function setTitle(string $title): void
    {
        $this->searchParams['body']['query']['bool']['must'] = [
            'match' => [
                'title' => [
                    'query' => $title,
                    'fuzziness' => '2',
                    'operator' => 'and',
                ],
            ]
        ];
    }

    private function setCategory(string $category): void
    {
        $this->searchParams['body']['query']['bool']['filter'][] = [
            'match' => [
                'category' => $category,
            ]
        ];
    }

    private function setPrice(string $price): void
    {
        $price = $this->transformCompareOperators($price);

        $this->searchParams['body']['query']['bool']['filter'][] = [
            'range' => [
                'price' => $price
            ]
        ];
    }

    private function setStock(string $count): void
    {
        $count = $this->transformCompareOperators($count);

        $this->searchParams['body']['query']['bool']['filter'][0]['nested']['query']['bool']['must'] = [
            'range' => [
                'stock.stock' => $count
            ]
        ];
    }


    /**
     * @param string $string
     * @return array
     */
    private function transformCompareOperators(string $string): array
    {
        $digit = preg_replace('/[><=]/', '', $string);

        if (!ctype_digit($digit)) {
            throw new InvalidArgumentException('Аргумент должен быть целым числом!');
        }

        $operators = [
            '<=' => 'lte',
            '>=' => 'gte',
            '<'  => 'lt',
            '>'  => 'gt',
        ];

        foreach ($operators as $operatorString => $operator) {
            if (str_contains($string, $operatorString)) {
                return [$operator => $digit];
            }
        }

        return [
            'lte' => $digit,
            'gte' => $digit,
        ];
    }


    private function renderResult(Elasticsearch|Promise $response, OutputInterface $output)
    {
        if (count($response['hits']['hits']) === 0) {
            $output->writeln('Книги по Вашему запросу не найдены!');
            return;
        }

        $table = new Table($output);
        $table->setHeaders(['Очки', 'Код', 'Название', 'Категория', 'Цена', 'Наличие']);
        $this->setRows($response['hits']['hits'], $table);

        while (count($response['hits']['hits']) > 0) {
            $response = $this->elasticClient->scroll([
                'body' => [
                    'scroll_id' => $response['_scroll_id'],
                    'scroll' => '1m',
                ],
            ]);

            $this->setRows($response['hits']['hits'], $table);
        }

        $table->render();

        $output->writeln("Найдено: {$response['hits']['total']['value']} записей");
    }

    private function setRows(array $hits, Table $table): void
    {
        foreach ($hits as $hit) {
            $stock = '';

            foreach ($hit['_source']['stock'] as $store) {
                $stock .= "ул. {$store['shop']} - {$store['stock']} шт.\n";
            }

            $table->addRow([
                number_format(floatval($hit['_score']), decimals: 2),
                $hit['_source']['sku'],
                $hit['_source']['title'],
                $hit['_source']['category'],
                "{$hit['_source']['price']} ₽",
                $stock
            ]);
        }
    }
}
