<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Illuminate\Database\Eloquent\Collection;
use Vp\App\Application\Contract\GetDataInterface;
use Vp\App\Application\Dto\Output\ResultGet;
use Vp\App\Domain\Model\Employee;
use Vp\App\Domain\Model\Timesheet;

class GetData implements GetDataInterface
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

        return new ResultGet(true, null, $timeSheets);
    }

    private function getEmployee(string $employeeName)
    {
        return Employee::where('name', $employeeName)->first();
    }

    private function getTimeSheets(Employee $employee): Collection
    {
        return Timesheet::where('employee_id', (string)$employee->id)->get();
    }
}
