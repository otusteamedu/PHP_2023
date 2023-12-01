<?php

namespace App\Before\Repository;

use App\Entity\EmployeeKpi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
class EmployeeKpiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeKpi::class);
    }

    public function findEmployeeWithoutKpi(string $filterDate): array
    {
        $em = $this->getEntityManager();
        [$month, $year] = explode('.', $filterDate);
        $filterDateWithLastDayMonth = date('Y-m-t', strtotime($year.'-'.$month));

        $subQuery = $em->createQueryBuilder()
            ->select('IDENTITY(ek.employee)')
            ->from('App\Entity\EmployeeKpi', 'ek')
            ->where('YEAR(ek.date) = :year AND MONTH(ek.date) = :month')
            ->getDQL();

        $query = $em->createQuery(
            "SELECT e
            FROM App\Entity\Employee e
                    INNER JOIN App\Entity\MotivationType mt WITH e.motivationType = mt.id
            WHERE mt.title = 'Оценки'
              AND e.status = 1
              AND e.dateStartWorking <= :filterDate
              AND e.id NOT IN ({$subQuery})
            ORDER BY e.lastName"
        )->setParameters([
            'filterDate' => $filterDateWithLastDayMonth,
            'year' => $year,
            'month' => $month,
        ]);

        return $query->getResult();
    }

    public function findEmployeeByProjectWithoutKpi(string $projectName, string $currentYearAndPreviousMonth): array
    {
        $em = $this->getEntityManager();
        [$year, $previousMonth] = explode('-', $currentYearAndPreviousMonth);

        $subQuery = $em->createQueryBuilder()
            ->select('IDENTITY(ek.employee)')
            ->from('App\Entity\EmployeeKpi', 'ek')
            ->where('YEAR(ek.date) = :year AND MONTH(ek.date) = :month')
            ->getDQL();

        $query = $em->createQueryBuilder()
            ->select("CONCAT(e.last_name, ' ', e.first_name, ' ', e.middle_name) AS full_name")
            ->from('App\Entity\Employee', 'e')
            ->innerJoin('e.project', 'p')
            ->where("e.id NOT IN ({$subQuery})")
            ->andWhere('p.title = :projectName')
            ->setParameter('year', $year)
            ->setParameter('month', $previousMonth)
            ->setParameter('projectName', $projectName)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @throws Exception
     */
    public function findAllWithFullName(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT CONCAT(e.last_name, ' ', e.first_name, ' ', e.middle_name) AS full_name,
                       TO_CHAR(ek.date,'YYYY-MM')                                 AS date,
                       ek.points, ek.comment
                FROM employee_kpi ek
                INNER JOIN employee e ON e.id = ek.employee_id
                ORDER BY e.last_name, date";
        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    /**
     * @throws Exception
     */
    public function getQuarterlyKpi(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT CONCAT(e.last_name, ' ', e.first_name, ' ', e.middle_name) AS full_name,
                       TO_CHAR(date_trunc('quarter', ek.date), 'YYYY.MM')         AS date,
                       ROUND(SUM(ek.points)::numeric, 1)                          AS points,
                       e.id                                                       AS employee_id,
                       e.salary_current
                FROM employee_kpi ek
                    INNER JOIN employee e ON e.id = ek.employee_id
                GROUP BY full_name, TO_CHAR(date_trunc('quarter', ek.date), 'YYYY.MM'), e.id, e.salary_current
                ORDER BY e.last_name, date";
        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    /**
     * @throws Exception
     */
    public function getQuarterlyCashPrizeForYear(string $yearOfFilter): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT CONCAT(e.last_name, ' ', e.first_name, ' ', e.middle_name) AS full_name,
                       TO_CHAR(cost.date, 'YYYY-MM')                              AS date,
                       cost.sum_kpi_cash_prize
                FROM employee e
                         INNER JOIN employee_cost cost ON e.id = cost.employee_id
                WHERE EXTRACT(YEAR FROM cost.date) = :yearOfFilter AND cost.sum_kpi_cash_prize > 0
                ORDER BY e.last_name, cost.date";

        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery([
            'yearOfFilter' => $yearOfFilter,
        ]);

        // returns an array of arrays (i.e. a raw data set)
        return $result->fetchAllAssociative();
    }

    /**
     * @throws Exception
     */
    public function getMonthlySalaryForYear(string $yearOfFilter): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT CONCAT(e.last_name, ' ', e.first_name, ' ', e.middle_name) AS full_name,
                       TO_CHAR(cost.date, 'YYYY-MM')                              AS date,
                       cost.sum_salary
                FROM employee e
                         INNER JOIN employee_cost cost ON e.id = cost.employee_id
                WHERE EXTRACT(YEAR FROM cost.date) = :yearOfFilter
                ORDER BY e.last_name, cost.date";

        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery([
            'yearOfFilter' => $yearOfFilter,
        ]);

        // returns an array of arrays (i.e. a raw data set)
        return $result->fetchAllAssociative();
    }
}
