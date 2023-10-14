<?php

declare(strict_types=1);

namespace App\Command;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDefaultIndexCommand extends Command
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
            ->setName('create:index')
            ->setDescription('Create default index \'otus-shop\'');
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $params = [
            'index' => 'otus-shop',
            'body' => [
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256
                                ]
                            ]
                        ],
                        'sku' => [
                            'type' => 'keyword'
                        ],
                        'category' => [
                            'type' => 'keyword'
                        ],
                        'price' => [
                            'type' => 'short'
                        ],
                        'stock' => [
                            'properties' => [
                                'shop' => [
                                    'type' => 'keyword'
                                ],
                                'stock' => [
                                    'type' => 'short'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        try {
            $this->client->indices()->create($params);
            $output->writeln("<comment>Index 'otus-shop' created</comment>");
        } catch (ClientResponseException|MissingParameterException|ServerResponseException $e) {
            $output->writeln("<comment>{$e->getMessage()}</comment>");
        }

        return 0;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
