<?php

declare(strict_types=1);

namespace App\Service\SalaryManager;

use App\After\Domain\Entity\EmployeeCost;
use App\After\Domain\Entity\Project;
use App\After\Domain\Entity\ProjectCost;
use App\After\Domain\Entity\TypeCost;
use DateTime;
use DateTimeImmutable;
use Exception;

class ProjectCostSaver implements CostManagerInterface
{
    /**
     * Monthly on the 5th the cost of salaries for project employees will be saved.
     */
    private const MONTH_DAY = '5';

    private const TYPE_COST = 'sal';

    private DateTime $currentDate;

    public function __construct(
        readonly EntityManagerInterface $entityManager,
    )
    {
        $this->currentDate = new DateTime();
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $dayOfCurrentMonth = $this->currentDate->format('d');

        if (self::MONTH_DAY !== $dayOfCurrentMonth) {
            throw new Exception("The current date is not correct: {$this->currentDate->format('Y-m-d')}");
        }

        $this->prepareProjectSalaryCosts();
    }

    /**
     * @throws Exception
     */
    private function prepareProjectSalaryCosts(): void
    {
        $employeeCostRepo = $this->entityManager->getRepository(EmployeeCost::class);
        $projects = $this->entityManager->getRepository(Project::class)->findAll();
        $typeCost = $this->entityManager->find(TypeCost::class, [
            'title' => self::TYPE_COST,
        ]);

        foreach ($projects as $project) {
            $sum = $employeeCostRepo->getProjectSalaryCostsForDate($project->getTitle());
            $this->newProjectCost($project, $typeCost, (float)$sum);
        }

        $this->entityManager->flush();
    }

    /**
     * @throws Exception
     */
    private function newProjectCost(
        Project $project,
        TypeCost $typeCost,
        float $sum
    ): void {
        $projectCost = new ProjectCost();
        $projectCost->setProject($project);
        $projectCost->setTypeCost($typeCost);
        $projectCost->setDate((new DateTimeImmutable())->modify('first day of this month'));
        $projectCost->setSum($sum);
        $projectCost->setCreatedAtAutomatically();
        $projectCost->setUpdatedAtAutomatically();

        $this->entityManager->persist($projectCost);
    }
}
