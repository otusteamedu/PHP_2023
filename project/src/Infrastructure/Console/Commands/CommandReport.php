<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Illuminate\Support\Collection;
use LucidFrame\Console\ConsoleTable;
use Vp\App\Application\Contract\ReportDataInterface;
use Vp\App\Infrastructure\Exception\MethodNotFound;

class CommandReport implements CommandInterface
{
    private ReportDataInterface $reportData;

    public function __construct(ReportDataInterface $reportData)
    {
        $this->reportData = $reportData;
    }
    /**
     * @throws MethodNotFound
     */
    public function run(string $object): void
    {
        switch ($object) {
            case 'top5longTasks':
            case 'top5costTasks':
            case 'top5employees':
                $result = $this->reportData->report($object);
                $table = $this->createConsoleTable($result->getResult(), $result->getAggregateField(), $result->getJoinedField());
                $table->display();
                break;
            default:
                fwrite(STDOUT, 'The object name is incorrect' . PHP_EOL);
        }
    }

    private function createConsoleTable(Collection $items, $aggregateField, $joinedField): ConsoleTable
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
