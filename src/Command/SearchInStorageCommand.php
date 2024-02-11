<?php
declare(strict_types=1);

namespace WorkingCode\Hw12\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WorkingCode\Hw12\DTO\Builder\EventDTOBuilder;
use WorkingCode\Hw12\Exception\InvalidArgumentException;
use WorkingCode\Hw12\Exception\NotFoundException;
use WorkingCode\Hw12\Helper\BuildHelper;
use WorkingCode\Hw12\Service\StorageInterface;

class SearchInStorageCommand extends Command
{
    use CommandTrait;
    use BuildHelper;

    private const ARGUMENT_CONDITIONS = 'conditions';

    public function __construct(
        private readonly StorageInterface $storage,
        private readonly EventDTOBuilder  $eventDTOBuilder,
    ) {
        parent::__construct();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $conditions = $input->getArgument(static::ARGUMENT_CONDITIONS);
        $this->checkStringArgument($conditions);
        $conditions = $this->getHashArrayFromString($conditions);

        try {
            $eventDTO = $this->storage->findOneByConditions($conditions, $this->eventDTOBuilder);

            $output->writeln(print_r($eventDTO->jsonSerialize(), true));
        } catch (NotFoundException $exception) {
            $output->writeln($exception->getMessage());
        }

        return static::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setName('storage:search')
            ->setDescription('search record in storage by conditions. Return record with max priority')
            ->addArgument(static::ARGUMENT_CONDITIONS, InputArgument::REQUIRED, 'Example: "param1=23;param2=3"');
    }
}
