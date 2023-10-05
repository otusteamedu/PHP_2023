<?php

namespace App\Console;

use App\ElasticSearch\CreateIndex;
use Elastic\Elasticsearch\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ImportFileCommand extends Command
{
    protected Client $client;

    public function __construct(string $name = null, Client $client = null)
    {
        parent::__construct($name);

        if ($client === null) {
            throw new \InvalidArgumentException('Not ES Client object');
        }

        $this->client = $client;
    }

    protected function configure()
    {
        $this->setName('es:import');
        $this->setDefinition([
            new InputArgument('file', InputArgument::REQUIRED, 'Path to the json file with data')
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output = $output instanceof SymfonyStyle ? $output : new SymfonyStyle($input, $output);

        $file = \trim((string)$input->getArgument('file'));

        $this->configure();

        if ('' === $file) {
            throw new \RuntimeException('File argument is required.');
        }

        $file = getcwd() . \DIRECTORY_SEPARATOR . $file;

        if (!file_exists($file)) {
            throw new \RuntimeException('File is not found. ' . $file);
        }

        $importer = new CreateIndex($this->client, 'otus-shop');
        $importer->indexFromFile($file);

        $output->comment($file);
        $output->success('Import completed.');

        return self::SUCCESS;
    }
}
