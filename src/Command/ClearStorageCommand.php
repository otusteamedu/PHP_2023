<?php
declare(strict_types=1);

namespace WorkingCode\Hw12\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WorkingCode\Hw12\Service\StorageInterface;

class ClearStorageCommand extends Command
{
    public function __construct(private readonly StorageInterface $storage)
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->storage->clearAll();
        $output->writeln('Хранилище очищено');

        return static::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setName('storage:clear')
            ->setDescription('clear storage');
    }
}
