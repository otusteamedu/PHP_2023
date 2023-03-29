<?php

declare(strict_types=1);

namespace Twent\BookShop\Commands;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Exception;
use Http\Promise\Promise;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class FindCommand extends Command
{
    protected static $defaultName = 'find:book';
    protected static $defaultDescription = 'Find books from Elasticsearch';
    private Client $elasticClient;
    protected array $searchParams;

    /**
     * @throws AuthenticationException
     */
    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->elasticClient = ClientBuilder::create()
            ->setBasicAuthentication('elastic', $_ENV['ELASTICSEARCH_PASSWORD'])
            ->build();

        $this->initSearchParams();
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

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->createIndexIfNotExists();

        $this->fillIndex($output);

        $response = $this->findBook($input);

        $this->renderResult($response, $output);

        return Command::SUCCESS;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws Exception
     */
    private function fillIndex(OutputInterface $output): void
    {
        $path = $_ENV['DATA_FILE_PATH'] ?? 'public/data.json';
        $filePath = __DIR__ . "/../../{$path}";

        if (! file_exists($filePath)) {
            throw new Exception('Файл с данными не найден!');
        }

        $data = file_get_contents($filePath);

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

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
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

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    private function createIndexIfNotExists()
    {
        if ($this->elasticClient->indices()->exists(['index' => 'otus-shop'])->getStatusCode() === 404) {
            $path = $_ENV['MAPPINGS_FILE_PATH'] ?? 'public/mappings.json';
            $filePath = __DIR__ . "/../../{$path}";

            if (! file_exists($filePath)) {
                return;
            }

            $data = file_get_contents($filePath);

            $params = [
                'index' => 'otus-shop',
                'body' => $data
            ];

            $this->elasticClient->indices()->create($params);
        }
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    private function findBook(InputInterface $input): Elasticsearch|Promise
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

    private function initSearchParams(): void
    {
        $this->searchParams = [
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

    private function transformCompareOperators(string $string): array
    {
        $digit = str_replace(['>', '<', '='], '', $string);

        if (! ctype_digit($digit)) {
            throw new InvalidArgumentException('Аргумент должен быть целым числом!');
        }

        if (str_contains($string, '<=')) {
            return ['lte' => $digit];
        }

        if (str_contains($string, '>=')) {
            return ['gte' => $digit];
        }

        if (str_contains($string, '<')) {
            return ['lt' => $digit];
        }

        if (str_contains($string, '>')) {
            return ['gt' => $digit];
        }

        return [
            'lte' => $digit,
            'gte' => $digit
        ];
    }
}
