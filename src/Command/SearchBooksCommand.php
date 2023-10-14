<?php

declare(strict_types=1);

namespace App\Command;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchBooksCommand extends Command
{
    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['https://localhost:9200'])
            ->setBasicAuthentication('elastic', '123456')
            ->setCABundle('http_ca.crt')
            ->build();

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('search:books')
            ->setDescription('Search books');
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        try {
            $params = [
                'index' => 'otus-shop',
                'body' => [
                    'query' => [
                        'match' => [
                            "sku" => '510-000'
                        ]
                    ]
                ]
            ];
            $response = $this->client->search($params);
            $output->writeln(
                sprintf("<comment>Total docs: %d\n</comment>", $response['hits']['total']['value'])
                . sprintf("<comment>Max score : %.4f\n</comment>", $response['hits']['max_score'])
                . sprintf("<comment>Took      : %d ms\n</comment>", $response['took'])
                . print_r($response['hits']['hits'], true)
            );
        } catch (ClientResponseException|ServerResponseException $e) {
            $output->writeln("<comment>{$e->getMessage()}</comment>");
        }

        return 0;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
