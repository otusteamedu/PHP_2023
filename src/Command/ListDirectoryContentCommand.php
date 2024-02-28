<?php
declare(strict_types=1);

namespace App\Command;

use App\Component\Factory\RenderFileSystemBasic;
use App\Component\Factory\RenderFileSystemExtended;
use App\Service\DirectoryService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListDirectoryContentCommand extends Command
{
    private const ARGUMENT_DIRECTORY = 'directory';
    private const OPTION             = 'extended';

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $directory      = $input->getArgument(static::ARGUMENT_DIRECTORY);
        $extendedOption = $input->getOption(static::OPTION);

        $renderFileSystem = $extendedOption
            ? new RenderFileSystemExtended()
            : new RenderFileSystemBasic();
        $directoryService = new DirectoryService($renderFileSystem);

        $output->writeln($directoryService->getTreeByDirectory($directory));

        return static::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setName('ls')
            ->setDescription('list directory contents')
            ->addArgument(static::ARGUMENT_DIRECTORY, InputArgument::REQUIRED)
            ->addOption(static::OPTION, '', InputOption::VALUE_NONE, 'advanced display mode');
    }
}
