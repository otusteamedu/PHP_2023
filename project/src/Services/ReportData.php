<?php

declare(strict_types=1);

namespace Vp\App\Services;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Connection;
use Illuminate\Support\Collection;
use LucidFrame\Console\ConsoleTable;
use Vp\App\Console\Result\ResultList;
use Vp\App\Exceptions\MethodNotFound;

class ReportData
{
    private Connection $db;

    /**
     * @throws MethodNotFound
     */
    public function report(string $context): ResultList
    {
        $methodName = __FUNCTION__ . ucfirst($context);

        if (!method_exists($this, $methodName )) {
            throw new MethodNotFound('Method not found');
        }

        $this->db = Manager::connection();

        $result = $this->{$methodName}();

        return new ResultList($result);
    }

    private function reportTop5longTasks(): ConsoleTable
    {
        $items = $this->db->table('timesheets')
            ->select($this->db->raw('SUM(ROUND((UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / 3600)) AS spent_hours'), 'tasks.title')
            ->leftJoin('tasks', 'timesheets.task_id', '=', 'tasks.id')
            ->groupBy('task_id')
            ->orderByDesc('spent_hours')
            ->take(5)
            ->get();

        return $this->createResult($items, 'spent_hours', 'title');
    }

    private function reportTop5costTasks(): ConsoleTable
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

        return $this->createResult($items, 'total_cost', 'title');
    }

    private function reportTop5employees(): ConsoleTable
    {
        $items = $this->db->table('timesheets')
            ->select($this->db->raw('SUM(ROUND((UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / 3600)) AS total_hours'), 'employees.name')
            ->leftJoin('employees', 'timesheets.employee_id', '=', 'employees.id')
            ->groupBy('employee_id')
            ->orderByDesc('total_hours')
            ->take(5)
            ->get();

        return $this->createResult($items, 'total_hours', 'name');
    }

    private function createResult(Collection $items, $aggregateField, $joinedField): ConsoleTable
    {
        $table = new ConsoleTable();
        $table->addHeader($aggregateField);
        $table->addHeader($joinedField);

        foreach ($items as $item) {
            $table->addRow();
            $table->addColumn($item->{$aggregateField});
            $table->addColumn($item->{$joinedField});
        }

        return $table;
    }
}
