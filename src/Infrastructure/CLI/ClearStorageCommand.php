<?php
declare(strict_types=1);

namespace App\Infrastructure\CLI;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\UseCase\ClearAllEventInterface;

class ClearStorageCommand extends Command
{
    public function __construct(private readonly ClearAllEventInterface $clearAllEvent)
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->clearAllEvent->clear();
        $output->writeln('Хранилище очищено');

        return static::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setName('storage:clear')
            ->setDescription('clear storage');
    }
}
