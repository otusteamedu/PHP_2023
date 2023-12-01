<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\DateGenerator\DateGenerator;
use App\Service\SalaryManager\ProjectCostSaver;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use MyBuilder\Bundle\CronosBundle\Annotation\Cron;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @Cron(minute="*", hour="/2", dayOfMonth="/5")
 */
class ProjectCostCommand extends Command
{
    public function __construct(
        readonly EntityManagerInterface $entityManager,
        readonly LoggerInterface $logger
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $projectSalarySaveService = new ProjectCostSaver($this->entityManager);

        try {
            $projectSalarySaveService->execute();
            $output->writeln(
                sprintf(
                    '<comment>Created projects costs at %s</comment>',
                    DateGenerator::getPreviousMonthDate()
                )
            );
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            $output->writeln(
                sprintf(
                    '<comment>Did not create projects costs at %s</comment>',
                    DateGenerator::getPreviousMonthDate()
                )
            );
        }

        return 0;
    }

    protected function configure()
    {
        $this
            ->setName('project-cost:create-employee-salary')
            ->setDescription('Creating monthly employee salaries');
    }
}

