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

class DeleteDefaultIndexCommand extends Command
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
            ->setName('delete:index')
            ->setDescription('Delete default index \'otus-shop\'');
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->client->indices()->delete(['index' => 'otus-shop']);
            $output->writeln("<comment>Index 'otus-shop' deleted</comment>");
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
