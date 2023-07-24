<?php

declare(strict_types=1);

namespace YuzyukRoman\Hw11\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use YuzyukRoman\Hw11\Elastic\Client;
use YuzyukRoman\Hw11\Elastic\SearchBoolQueryBuilder;
use YuzyukRoman\Hw11\Interface\ConsoleQuestion;
use YuzyukRoman\Hw11\Services\SearchResultsProcessor;

#[AsCommand(
    name: 'app:search',
    description: 'Fill table from json file.',
)]
class SearchBook extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $question = new ConsoleQuestion($input, $output, $this->getHelperSet());

        $bookName = $question->askQuestion('Название книги: ');
        $bookSku = $question->askQuestion('Артикул книги: ');
        $bookCategory = $question->askQuestion('Категория книги: ');
        $minPrice = $question->askQuestion('Минимальная цена: ');
        $maxPrice = $question->askQuestion('Максимаьная цена: ');

        $client = Client::connect("{$_ENV['ELASTIC_HOST']}:{$_ENV['ELASTIC_PORT']}");

        $builder = new SearchBoolQueryBuilder('otus-shop');
        $query = $builder
            ->match('title', $bookName)
            ->term('sku', $bookSku, 'must')
            ->term('category', $bookCategory, 'must')
            ->range('price', ['gte' => $minPrice, 'lte' => $maxPrice], 'must')
            ->build();

        $response = $client->search($query);

        $table = new Table($output);
        $table->setHeaders(['Title', 'SKU', 'Category', 'Price', 'Shop', 'Stock']);

        $data = $response['hits']['hits'];
        $books = SearchResultsProcessor::processResults($data);

        foreach ($books as $book) {
            $table->addRow([
                $book->title,
                $book->sku,
                $book->category,
                $book->price,
                $book->shop,
                $book->stockAmount
            ]);
        }

        $table->render();

        return self::SUCCESS;
    }
}
