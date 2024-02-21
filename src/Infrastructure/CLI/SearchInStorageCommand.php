<?php
declare(strict_types=1);

namespace App\Infrastructure\CLI;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\DTO\ConditionDTO;
use App\Application\DTO\OccasionDTO;
use App\Application\Helper\BuildHelper;
use App\Application\UseCase\SearchEventInterface;
use App\Domain\Exception\NotFoundException;

class SearchInStorageCommand extends Command
{
    private const ARGUMENT_CONDITIONS = 'conditions';

    public function __construct(
        private readonly SearchEventInterface $searchEvent,
        private readonly BuildHelper          $buildHelper,
    ) {
        parent::__construct();
    }


    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $conditions    = $input->getArgument(static::ARGUMENT_CONDITIONS);
        $conditions    = $this->buildHelper->getHashArrayFromString($conditions);
        $conditionsDTO = [];

        foreach ($conditions as $operandLeft => $operandRight) {
            $conditionsDTO[] = new ConditionDTO($operandLeft, $operandRight);
        }

        try {
            $eventDTO = $this->searchEvent->searchBy($conditionsDTO);

            $listEvent     = array_map(
                static fn (OccasionDTO $occasionDTO): string => $occasionDTO->getName()
                    . '=' . $occasionDTO->getValue(),
                $eventDTO->getEvent()
            );
            $listCondition = array_map(
                static fn (ConditionDTO $conditionDTO): string => $conditionDTO->getOperandLeft()
                    . '=' . $conditionDTO->getOperandRight(),
                $eventDTO->getConditions()
            );

            $output->writeln(sprintf(
                "priority:%s\nconditions:%s\nevent:%s\n",
                $eventDTO->getPriority(),
                implode(';', $listEvent),
                implode(';', $listCondition),
            ));
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
