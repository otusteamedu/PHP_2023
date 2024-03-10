<?php
declare(strict_types=1);

namespace App\Application;

use App\Elasticsearch\ElasticsearchClient;

class App
{
    private const HOST = 'localhost';
    private const PORT = 9200;
    private const INDEX = 'bookstore';


    public function __construct(
        private string $request
    )
    {
    }


    public function run()
    {
        $this->processBookstore();

        $client = new ElasticsearchClient(self::HOST, self::PORT);
        $result = $client->search(self::INDEX, $this->request);

    }

    private function processBookstore()
    {
        $client = new ElasticsearchClient(self::HOST, self::PORT);
        $booksData = json_decode(file_get_contents('books.json'), true);
        $client->createIndex(self::INDEX);
        foreach ($booksData as $book) {
            $client->indexDocument(self::INDEX, $book);
        }
    }
}