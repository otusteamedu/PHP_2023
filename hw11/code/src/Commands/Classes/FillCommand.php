<?php

namespace Gkarman\Otuselastic\Commands\Classes;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class FillCommand extends AbstractCommand
{
    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function run(): string
    {
        $params = [
            'index' => 'otus-shop',
            'id' => '1',
            'body' => [
                'title' => 'php',
            ],
        ];
echo 111111;
        $this->elasticClient->index($params);
        return 'ok';
    }

    private function getJSON(): string
    {
        return file_get_contents("src/Storage/books.json");
    }

}
