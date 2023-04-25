<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Illuminate\Database\Eloquent\Collection;
use LucidFrame\Console\ConsoleTable;
use Vp\App\Application\Contract\ListDataInterface;
use Vp\App\Domain\Model\Employee;
use Vp\App\Infrastructure\Exception\MethodNotFound;

class CommandList implements CommandInterface
{
    private ListDataInterface $listData;

    public function __construct(ListDataInterface $listData)
    {
        $this->listData = $listData;
    }

    /**
     * @throws MethodNotFound
     */
    public function run(string $object): void
    {
        switch ($object) {
            case 'employee':
                $result = $this->listData->list($object);
                $table = $this->createConsoleTable($result->getResult());
                $table->display();
                break;
            default:
                fwrite(STDOUT, 'The object name is incorrect' . PHP_EOL);
        }
    }

    private function createConsoleTable(Collection $employees): ConsoleTable
    {
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
