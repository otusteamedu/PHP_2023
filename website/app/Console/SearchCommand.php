<?php

declare(strict_types=1);

namespace App\Console;

use App\ElasticSearch\Search;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class SearchCommand extends Command
{
    protected Client $client;

    public function __construct(string $name = null, Client $client = null)
    {
        parent::__construct($name);

        if ($client === null) {
            throw new InvalidArgumentException('Not ES Client object');
        }

        $this->client = $client;
    }

    protected function configure()
    {
        $this->setName('es:search');
        $this->setDefinition([
            new InputArgument('query', InputArgument::REQUIRED),
            new InputArgument('maxPrice', InputArgument::OPTIONAL)
        ]);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output = $output instanceof SymfonyStyle ? $output : new SymfonyStyle($input, $output);

        $query = trim((string)$input->getArgument('query'));
        $maxPrice = (int)$input->getArgument('maxPrice');

        $this->configure();
        if ('' === $query) {
            throw new RuntimeException('Query argument is required.');
        }

        $search = new Search($this->client, 'otus-shop');
        $result = $search->search($query, $maxPrice);

        $output->comment($result ?: ['Not found.']);
        $output->success('Import completed.');

        return self::SUCCESS;
    }
}