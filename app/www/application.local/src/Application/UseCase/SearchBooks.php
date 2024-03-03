<?php

declare(strict_types=1);


namespace AYamaliev\hw11\Application\UseCase;


use AYamaliev\hw11\Application\OutputResult;
use AYamaliev\hw11\Infrastructure\Repository\ElasticSearchRepository;
use Elastic\Elasticsearch\ClientBuilder;
use http\Encoding\Stream\Debrotli;

class SearchBooks
{

    public function __invoke($argv)
    {
        $client = ClientBuilder::create()
            ->setHosts(['https://elasticsearch:9200'])
            ->setSSLVerification(false)
            ->setBasicAuthentication($_ENV['ELASTIC_USERNAME'], $_ENV['ELASTIC_PASSWORD'])
            ->build();

        $app = new ElasticSearchRepository($client, $argv);
        $response = $app->search();
        ((new OutputResult())($response));
    }
}
