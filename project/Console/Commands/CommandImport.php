<?php

declare(strict_types=1);

namespace Console\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Exceptions\MethodNotFound;
use Services\Container;

class CommandImport implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws MethodNotFound
     */
    public function run(string $object): void
    {
        $importData = Container::getInstance()->get('Services\ImportData');

        $result = match ($object) {
            'positions.csv' => $importData->import($object, 'positions'),
            'employees.csv' => $importData->import($object, 'employees'),
            'timesheet.csv' => $importData->import($object, 'timesheet'),
            default => $importData->importDefault(),
        };

        echo $result->getMessage();
    }
}
