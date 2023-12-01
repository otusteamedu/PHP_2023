<?php

declare(strict_types=1);

namespace App\After\Infrustructures\Command;

use App\After\Application\Service\SalaryManager\EmployeeCostSaver;
use Exception;
use MyBuilder\Bundle\CronosBundle\Annotation\Cron;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @Cron(minute="*", hour="/1", dayOfMonth="/5")
 */
class EmployeeCostCommand extends CommandTemplateAbstract
{
    public function __construct(
        readonly EmployeeCostSaver $salarySaveService,
        readonly LoggerInterface   $logger
    )
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->salarySaveService->execute();
            $output->writeln(
                sprintf('<comment>Created employee salaries at %s</comment>',
                    DateGenerator::getPreviousMonthDate()
                )
            );
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            $output->writeln(
                sprintf('<comment>Did not create employee salaries at %s</comment>',
                    DateGenerator::getPreviousMonthDate()
                )
            );
        }

        return self::SUCCESS_CODE;
    }

    protected function configure()
    {
        $this
            ->setName('employee-cost:create-employee-salary')
            ->setDescription('Creating monthly employee salaries');
    }
}
