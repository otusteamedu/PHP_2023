<?php

declare(strict_types=1);

namespace App\After\Infrustructures\Command;

use App\After\Application\Service\SalaryManager\ProjectCostSaver;
use Doctrine\ORM\EntityManagerInterface;
use MyBuilder\Bundle\CronosBundle\Annotation\Cron;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @Cron(minute="*", hour="/2", dayOfMonth="/5")
 */
class ProjectCostCommand extends CommandTemplateAbstract
{
    public function __construct(
        readonly ProjectCostSaver $projectSalarySaveService,
        readonly LoggerInterface  $logger
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('project-cost:create-employee-salary')
            ->setDescription('Creating monthly employee salaries');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->projectSalarySaveService->execute();
            $output->writeln(
                sprintf('<comment>Created projects costs at %s</comment>',
                    DateGenerator::getPreviousMonthDate()
                )
            );
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            $output->writeln(
                sprintf('<comment>Did not create projects costs at %s</comment>',
                    DateGenerator::getPreviousMonthDate()
                )
            );
        }

        return self::SUCCESS_CODE;
    }
}
