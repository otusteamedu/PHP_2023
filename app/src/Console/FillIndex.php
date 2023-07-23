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
    name: 'app:fill-index',
    description: 'Fill table from json file.',
)]
class FillIndex extends Command
{
    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'Path to file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $workdir = getcwd();
        $pathToFile = $workdir . $input->getArgument("path");
        $inputData = file_get_contents($pathToFile);

        if (!$inputData) {
            $output->writeln("<error>No such file or directory in</error>" . $inputData);
            return self::FAILURE;
        }

        $lines = explode("\n", trim($inputData));
        $sendData = [];

        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }

            $sendData[] = json_decode($line, true);
        }

        $client = Client::connect("elastic:9200");

        $client->bulk(['body' => $sendData]);

        $output->writeln("<info>Done!</info>");

        return self::SUCCESS;
    }
}
