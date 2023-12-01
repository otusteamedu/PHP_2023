<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\DateGenerator\DateGenerator;
use App\Service\SalaryManager\EmployeeCostSaver;
use Doctrine\ORM\EntityManagerInterface;
use MyBuilder\Bundle\CronosBundle\Annotation\Cron;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

/**
 * @Cron(minute="*", hour="/1", dayOfMonth="/5")
 */
class EmployeeCostCommand extends Command
{
    public function __construct(
        readonly EntityManagerInterface $entityManager,
        readonly LoggerInterface $logger
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('employee-cost:create-employee-salary')
            ->setDescription('Creating monthly employee salaries');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $salarySaveService = new EmployeeCostSaver($this->entityManager);

        try {
            $salarySaveService->execute();
            $output->writeln(
                sprintf('<comment>Created employee salaries at %s</comment>',
                    DateGenerator::getPreviousMonthDate()
                )
            );
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $output->writeln(
                sprintf('<comment>Did not create employee salaries at %s</comment>',
                    DateGenerator::getPreviousMonthDate()
                )
            );
        }

        return 0;
    }
}
