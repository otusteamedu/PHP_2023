<?php

namespace Radovinetch\Hw11\commands;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Radovinetch\Hw11\document\Book;

class SearchController extends Command
{
    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function run(array $options): void
    {
        if (!isset($options['q'], $options['p'])) {
            echo 'Используйте php index.php -с search -q "поисковой запрос" -p цена' . PHP_EOL;
            return;
        }

        Book::printHeadStatic();
        $books = Book::search($this->storage, ['query' => $options['q'], 'price' => $options['p']]);
        foreach ($books as $book) {
            $book->printDocument();
        }
    }
}