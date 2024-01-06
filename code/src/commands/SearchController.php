<?php

namespace Radovinetch\Hw11\commands;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class SearchController extends Command
{
    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function run(array $options): void
    {
        if (!isset($options['q'])) {
            echo 'Используйте php index.php -с search -q "поисковой запрос" -p цена' . PHP_EOL;
        }

        $result = $this->storage->search($options['q'], $options['p'])->asArray();
        echo 'Название | SKU | Категория | Цена' . PHP_EOL;
        foreach ($result['hits']['hits'] as $hit) {
            $_source = $hit['_source'];
            echo $_source['title'] . ' | ' . $_source['sku'] . ' | ' . $_source['category'] . ' | ' . $_source['price'] . PHP_EOL;
        }
    }
}