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
use Yalanskiy\SearchApp\Book;

/**
 * Команда для поиска книг
 */
class FindBookCommand extends FindCommand
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

        parent::execute($input, $output);

        if (count($this->searchResult['hits']['hits']) === 0) {
            $output->writeln('Book not found!');
            return 0;
        }

        $table = new Table($output);
        $table->setHeaders(Book::$headers);

        Book::fillRows($table, $this->searchResult['hits']['hits']);

        while (count($this->searchResult['hits']['hits']) > 0) {
            $this->searchResult = $this->service->scroll([
                'body' => [
                    'scroll_id' => $this->searchResult['_scroll_id'],
                    'scroll' => '1m',
                ],
            ]);

            Book::fillRows($table, $this->searchResult['hits']['hits']);
        }

        $table->render();

        $output->writeln("Found: {$this->searchResult['hits']['total']['value']} books");

        return Command::SUCCESS;
    }
}
