<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use LucidFrame\Console\ConsoleTable;
use Vp\App\Domain\Model\Employee;
use Vp\App\Infrastructure\Console\Result\ResultList;
use Vp\App\Infrastructure\Exception\MethodNotFound;

class ListData
{
    /**
     * @throws MethodNotFound
     */
    public function list(string $context): ResultList
    {
        $methodName = __FUNCTION__ . ucfirst($context);

        if (!method_exists($this, $methodName )) {
            throw new MethodNotFound('Method not found');
        }

        $result = $this->{$methodName}();

        return new ResultList($result);
    }

    private function listEmployee(): ConsoleTable
    {
        $employees = Employee::all();

        $table = new ConsoleTable();
        $table->addHeader('№');
        $table->addHeader('Name');

        $listNumber = 0;

        /** @var Employee $employee */
        foreach ($employees as $employee) {
            $listNumber++;
            $table->addRow();
            $table->addColumn($listNumber);
            $table->addColumn($employee->name);
        }

        return $table;
    }
}
