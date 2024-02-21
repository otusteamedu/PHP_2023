<?php
declare(strict_types=1);

namespace App\Infrastructure\CLI;

use App\Application\UseCase\AddEventInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\DTO\Builder\EventDTOBuilder;

class AddRecordInStorageCommand extends Command
{
    private const ARGUMENT_PRIORITY   = 'priority';
    private const ARGUMENT_CONDITIONS = 'conditions';
    private const ARGUMENT_EVENTS     = 'events';

    public function __construct(
        private readonly AddEventInterface $addEvent,
        private readonly EventDTOBuilder   $eventDTOBuilder,
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $priority   = (int)$input->getArgument(static::ARGUMENT_PRIORITY);
        $conditions = $input->getArgument(static::ARGUMENT_CONDITIONS);
        $events     = $input->getArgument(static::ARGUMENT_EVENTS);

        $eventDTO = $this->eventDTOBuilder->build($priority, $conditions, $events);
        $this->addEvent->add($eventDTO);

        $output->writeln('Запись успешно добавлена');

        return static::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setName('storage:add')
            ->setDescription('add record in storage')
            ->addArgument(static::ARGUMENT_PRIORITY, InputArgument::REQUIRED, 'Example: 1000')
            ->addArgument(static::ARGUMENT_CONDITIONS, InputArgument::REQUIRED, 'Example: "param1=23;param2=3"')
            ->addArgument(static::ARGUMENT_EVENTS, InputArgument::REQUIRED, 'Example: "event1=value;eventN=valueN"');
    }
}
