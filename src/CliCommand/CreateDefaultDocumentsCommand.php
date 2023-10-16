<?php

declare(strict_types=1);

namespace App\CliCommand;

use App\Service\DocumentsCreator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDefaultDocumentsCommand extends CommandTemplate
{
    protected function configure()
    {
        $this
            ->setName('create:documents')
            ->setDescription('Create 10000 default documents');
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<comment>10000 documents creating... Wait please</comment>");
        (new DocumentsCreator())->execute();
        $output->writeln("<comment>10000 documents created</comment>");

        return self::SUCCESS_CODE;
    }
}


