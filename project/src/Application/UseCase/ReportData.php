<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Connection;
use Vp\App\Application\Contract\ReportDataInterface;
use Vp\App\Application\Dto\Output\ResultReport;
use Vp\App\Infrastructure\Exception\MethodNotFound;

class ReportData implements ReportDataInterface
{
    private Connection $db;

    /**
     * @throws MethodNotFound
     */
    public function report(string $context): ResultReport
    {
        $methodName = __FUNCTION__ . ucfirst($context);

        if (!method_exists($this, $methodName )) {
            throw new MethodNotFound('Method not found');
        }

        $this->db = Manager::connection();
        return $this->{$methodName}();
    }

    private function reportTop5longTasks(): ResultReport
    {
        $items = $this->db->table('timesheets')
            ->select($this->db->raw('SUM(ROUND((UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / 3600)) AS spent_hours'), 'tasks.title')
            ->leftJoin('tasks', 'timesheets.task_id', '=', 'tasks.id')
            ->groupBy('task_id')
            ->orderByDesc('spent_hours')
            ->take(5)
            ->get();

        return new ResultReport($items, 'spent_hours', 'title');
    }

    private function reportTop5costTasks(): ResultReport
    {
        $items = $this->db->table('timesheets')
            ->select(
                $this->db->raw('SUM( ROUND((UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / 3600) * (SELECT positions.rate FROM employees JOIN positions ON employees.position_id = positions.id WHERE employees.id = timesheets.employee_id) ) AS total_cost'),
                'tasks.title'
            )
            ->leftJoin('tasks', 'timesheets.task_id', '=', 'tasks.id')
            ->groupBy('task_id')
            ->orderByDesc('total_cost')
            ->take(5)
            ->get();

        return new ResultReport($items, 'total_cost', 'title');
    }

    private function reportTop5employees(): ResultReport
    {
        $items = $this->db->table('timesheets')
            ->select($this->db->raw('SUM(ROUND((UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / 3600)) AS total_hours'), 'employees.name')
            ->leftJoin('employees', 'timesheets.employee_id', '=', 'employees.id')
            ->groupBy('employee_id')
            ->orderByDesc('total_hours')
            ->take(5)
            ->get();

        return new ResultReport($items, 'total_hours', 'name');
    }
}
