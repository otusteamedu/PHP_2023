<?php

namespace YuzyukRoman\Hw11\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use YuzyukRoman\Hw11\Elastic\Client;
use YuzyukRoman\Hw11\Elastic\SearchBoolQueryBuilder;
use YuzyukRoman\Hw11\Interface\ConsoleQuestion;

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

        $client = Client::connect('elastic:9200');

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
        foreach ($data as $hit) {
            $title = $hit['_source']['title'];
            $sku = $hit['_id'];
            $category = $hit['_source']['category'];
            $price = $hit['_source']['price'];

            foreach ($hit['_source']['stock'] as $stock) {
                $shop = $stock['shop'];
                $stockAmount = $stock['stock'];
                $table->addRow([$title, $sku, $category, $price, $shop, $stockAmount]);
            }
        }

        $table->render();

        return self::SUCCESS;
    }
}
