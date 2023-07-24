<?php

declare(strict_types=1);

namespace YuzyukRoman\Hw11\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use YuzyukRoman\Hw11\Elastic\Client;

#[AsCommand(
    name: 'app:create-index',
    description: 'Fill table from json file.',
)]
class CreateIndex extends Command
{
    protected function configure(): void
    {
        $this->addArgument('index_name', InputArgument::REQUIRED, 'Index name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('index_name');
        $client = Client::connect("{$_ENV['ELASTIC_HOST']}:{$_ENV['ELASTIC_PORT']}");

        $client->indices()->create([
            'index' => $name,
            'body' => [
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text',
                            'analyzer' => 'russian',
                        ],
                        'sku' => [
                            'type' => 'keyword',
                        ],
                        'category' => [
                            'type' => 'keyword',
                        ],
                        'price' => [
                            'type' => 'integer',
                        ],
                        'stock' => [
                            'type' => 'nested',
                            'properties' => [
                                'shop' => [
                                    'type' => 'keyword',
                                ],
                                'stock' => [
                                    'type' => 'integer',
                                ],
                            ],
                        ],
                    ],
                ],
                'settings' => [
                    'analysis' => [
                        'analyzer' => [
                            'russian' => [
                                'tokenizer' => 'standard',
                                'filter' => ['lowercase', 'russian_morphology'],
                            ],
                        ],
                        'filter' => [
                            'russian_morphology' => [
                                'type' => 'stemmer',
                                'language' => 'russian',
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $output->writeln("<info>Index $name created</info>");

        return self::SUCCESS;
    }
}
