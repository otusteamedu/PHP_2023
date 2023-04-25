<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Illuminate\Database\Eloquent\Collection;
use LucidFrame\Console\ConsoleTable;
use Vp\App\Application\Contract\GetDataInterface;
use Vp\App\Domain\Model\Timesheet;

class CommandGet implements CommandInterface
{
    private GetDataInterface $getData;

    public function __construct(GetDataInterface $getData)
    {
        $this->getData = $getData;
    }

    public function run(string $object): void
    {
        $result = $this->getData->get($object);

        if ($result->isSuccess()) {
            $table = $this->createConsoleTable($result->getResult());
            $table->display();
            return;
        }

        fwrite(STDOUT, $result . PHP_EOL);
    }

    private function createConsoleTable(Collection $timeSheets): ConsoleTable
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
