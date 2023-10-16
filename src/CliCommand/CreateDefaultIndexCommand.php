<?php

declare(strict_types=1);

namespace App\CliCommand;

use App\Service\IndexCreator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDefaultIndexCommand extends CommandTemplate
{
    protected function configure()
    {
        $this
            ->setName('create:index')
            ->setDescription("Create default index '" . self::INDEX_NAME . "'");
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {

        (new IndexCreator())->execute(self::INDEX_NAME);

        $output->writeln("<comment>Index '" . self::INDEX_NAME . "' created</comment>");

        return self::SUCCESS_CODE;
    }
}
