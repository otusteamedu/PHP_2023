<?php

declare(strict_types=1);

namespace Twent\BookShop\Commands;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class FindCommand extends Command
{
    protected static $defaultName = 'find:book';
    protected static $defaultDescription = 'Find books from Elasticsearch';
    private Client $elasticClient;

    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->elasticClient = ClientBuilder::create()
            ->setBasicAuthentication('elastic', $_ENV['ELASTICSEARCH_PASSWORD'])
            ->build();
    }

    protected function configure(): void
    {
        $this
            ->setHelp("Используйте опции:\n--title 'Терминатор' или -t'Терминатор'\n--category 'Сад и огород' или -с'Сад и огород'\n--price='<=334' или -p'334'\n--stock='>=20' или -s'20'\n\nПример команды: bin/console --title='Терминатор' --category='Искусство' --price='<500' --stock='>=20'")
            ->addOption('title', 't', InputOption::VALUE_OPTIONAL, 'Название книги')
            ->addOption('category', 'c', InputOption::VALUE_OPTIONAL, 'Категория')
            ->addOption('price', 'p', InputOption::VALUE_OPTIONAL, 'Цена вида >=100, 100, <=100')
            ->addOption('stock', 's', InputOption::VALUE_OPTIONAL, 'Остаток вида >=100, 100, <=100');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->createIndexIfNotExists();

        $this->fillIndex($output);

        $this->findBook($input, $output);

        return Command::SUCCESS;
    }

    private function fillIndex(OutputInterface $output)
    {
        $data = file_get_contents(__DIR__ . '/../../public/data.json');

        $params = [
            'body' => $data
        ];

        $response = $this->elasticClient->bulk($params)->asObject();

        if ($response->errors) {
            $output->writeln("Индекс otus-shop уже заполнен данными.");
        } else {
            $itemsCount = count($response->items);
            $output->writeln("Индекс otus-shop успешно заполнен ({$itemsCount} записей)\n");
        }
    }

    private function findBook(InputInterface $input, OutputInterface $output)
    {
        $searchParams = [
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

        if ($input->getOption('title')) {
            $searchParams['body']['query']['bool']['must'] = [
                'match' => [
                    'title' => [
                        'query' => $input->getOption('title'),
                        'fuzziness' => '2',
                        'operator' => 'and',
                    ],
                ]
            ];
        }

        if ($input->getOption('category')) {
            $searchParams['body']['query']['bool']['filter'][] = [
                'term' => [
                    'category.keyword' => $input->getOption('category')
                ]
            ];
        }

        if ($price = $input->getOption('price')) {
            $price = $this->transformCompareOperators($price);

            $searchParams['body']['query']['bool']['filter'][] = [
                'range' => [
                    'price' => $price
                ]
            ];
        }

        if ($count = $input->getOption('stock')) {
            $count = $this->transformCompareOperators($count);

            $searchParams['body']['query']['bool']['filter'][0]['nested']['query']['bool']['must'] = [
                'range' => [
                    'stock.stock' => $count
                ]
            ];
        }

        $response = $this->elasticClient->search($searchParams);

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

        $table->addRow(new TableSeparator());
    }

    private function createIndexIfNotExists()
    {
        if ($this->elasticClient->indices()->exists(['index' => 'otus-shop'])->getStatusCode() === 404) {
            $data = file_get_contents(__DIR__ . '/../../public/mappings.json');

            $params = [
                'index' => 'otus-shop',
                'body' => $data
            ];

            $this->elasticClient->indices()->create($params);
        }
    }

    private function transformCompareOperators(string $string): array
    {
        $getCleanDigital = fn(string $string) => str_replace(['>', '<', '='], '', $string);

        if (str_contains($string, '<=')) {
            $arrayQuery = ['lte' => $getCleanDigital($string)];
        } elseif (str_contains($string, '>=')) {
            $arrayQuery = ['gte' => $getCleanDigital($string)];
        } elseif (str_contains($string, '<')) {
            $arrayQuery = ['lt' => $getCleanDigital($string)];
        } elseif (str_contains($string, '>')) {
            $arrayQuery = ['gt' => $getCleanDigital($string)];
        } else {
            $arrayQuery = [
                'lte' => $getCleanDigital($string),
                'gte' => $getCleanDigital($string)
            ];
        }

        return $arrayQuery;
    }
}
