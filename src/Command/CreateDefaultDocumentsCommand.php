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

class CreateDefaultDocumentsCommand extends Command
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
            ->setName('create:documents')
            ->setDescription('Create 10000 default documents');
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $file = __DIR__ . '/../../books.json';
        $handle = fopen($file, "r");

        while (!feof($handle)) {
            $line = fgets($handle);

            if (!empty($line)) {
                $document = json_decode($line, true);

                if (isset($document['create'])) {
                    $index = $document['create']['_index'];
                    $id = $document['create']['_id'];
                    $indexAndId = [
                        'index' => $index,
                        'id' => $id
                    ];
                }

                if (isset($document['title'])) {
                    $body = ['body' => $document];
                    $param = array_merge($indexAndId, $body);

                    try {
                        $this->client->index($param);
                        $output->writeln("<comment>Document {$id} created</comment>");
                    } catch (ClientResponseException|MissingParameterException|ServerResponseException $e) {
                        $output->writeln("<comment>{$e->getMessage()}</comment>");
                    }
                }
            }
        }

        fclose($handle);

        return 0;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
