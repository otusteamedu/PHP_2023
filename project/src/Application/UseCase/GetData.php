<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Illuminate\Database\Eloquent\Collection;
use LucidFrame\Console\ConsoleTable;
use Vp\App\Domain\Model\Employee;
use Vp\App\Domain\Model\Timesheet;
use Vp\App\Infrastructure\Console\Result\ResultGet;

class GetData
{
    public function get(string $employeeName): ResultGet
    {
        $employee = $this->getEmployee($employeeName);

        if (!$employee) {
            return new ResultGet(false, 'This employee was not found.' . PHP_EOL);
        }

        $timeSheets = $this->getTimeSheets($employee);

        if ($timeSheets->count() < 1) {
            return new ResultGet(false, 'No records found for this employee.' . PHP_EOL);
        }

        $table = $this->createConsoleTable($timeSheets);
        return new ResultGet(true, null, $table);
    }

    private function getEmployee(string $employeeName)
    {
        return Employee::where('name', $employeeName)->first();
    }

    private function getTimeSheets(Employee $employee): Collection
    {
        return Timesheet::where('employee_id', (string)$employee->id)->get();
    }

    private function createConsoleTable($timeSheets): ConsoleTable
    {
        $table = new ConsoleTable();
        $table
            ->addHeader('id')
            ->addHeader('employee_id')
            ->addHeader('task_id')
            ->addHeader('start_time')
            ->addHeader('end_time');

        /** @var Timesheet $timeSheet */
        foreach ($timeSheets as $timeSheet) {
            $table->addRow()
                ->addColumn($timeSheet->id)
                ->addColumn($timeSheet->employee_id)
                ->addColumn($timeSheet->task_id)
                ->addColumn($timeSheet->start_time)
                ->addColumn($timeSheet->end_time);
        }
        return $table;
    }
}
