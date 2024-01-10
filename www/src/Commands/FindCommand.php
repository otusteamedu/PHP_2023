<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Commands;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Yalanskiy\SearchApp\ElasticService;

/**
 * Команда для поиска книг
 */
class FindCommand extends Command
{
    private array $options = [
        [
            'name' => 'title',
            'shortcut' => 't',
            'description' => 'Book title'
        ],
        [
            'name' => 'category',
            'shortcut' => 'c',
            'description' => 'Book category'
        ],
        [
            'name' => 'price',
            'shortcut' => 'p',
            'description' => 'Book price (>=1000, 1000, <=1000)'
        ],
        [
            'name' => 'stock',
            'shortcut' => 's',
            'description' => 'Stock amount (>=5, 5, <=5)'
        ],
    ];

    private ElasticService $service;

    public function __construct(ElasticService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName('find')
            ->setDescription("Find books by parameters")
            ->setHelp(
                "Find books by parameters"
            );

        foreach ($this->options as $option) {
            $this->addOption($option['name'], $option['shortcut'], InputOption::VALUE_OPTIONAL, $option['description']);
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->options as $option) {
            if ($value = $input->getOption($option['name'])) {
                $this->service->setSearchParam($option['name'], $value);
            }
        }

        $result = $this->service->search();

        if (count($result['hits']['hits']) === 0) {
            $output->writeln('Book not found!');
            return 0;
        }

        $table = new Table($output);
        $table->setHeaders(['Scores', 'SKU', 'Title', 'Category', 'Price', 'Stock']);

        $this->fillRows($table, $result['hits']['hits']);

        while (count($result['hits']['hits']) > 0) {
            $result = $this->service->scroll([
                'body' => [
                    'scroll_id' => $result['_scroll_id'],
                    'scroll' => '1m',
                ],
            ]);

            $this->fillRows($table, $result['hits']['hits']);
        }

        $table->render();

        $output->writeln("Found: {$result['hits']['total']['value']} books");

        return Command::SUCCESS;
    }

    /**
     * Fill table rows from data array
     *
     * @param Table $table
     * @param array $data
     *
     * @return void
     */
    private function fillRows(Table $table, array $data): void
    {
        foreach ($data as $item) {
            $stock = '';

            foreach ($item['_source']['stock'] as $store) {
                $stock .= "{$store['shop']}: {$store['stock']}\n";
            }

            $table->addRow([
                number_format(floatval($item['_score']), decimals: 2),
                $item['_source']['sku'],
                $item['_source']['title'],
                $item['_source']['category'],
                $item['_source']['price'],
                $stock
            ]);
        }
    }
}
