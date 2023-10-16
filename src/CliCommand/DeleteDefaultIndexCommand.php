<?php

declare(strict_types=1);

namespace App\CliCommand;

use App\Service\IndexDeleter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteDefaultIndexCommand extends CommandTemplate
{
    protected function configure()
    {
        $this
            ->setName('delete:index')
            ->setDescription("Delete default index '" . self::INDEX_NAME . "'");
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        (new IndexDeleter())->execute(self::INDEX_NAME);

        $output->writeln("<comment>Index '" . self::INDEX_NAME . "' deleted</comment>");

        return self::SUCCESS_CODE;
    }
}
