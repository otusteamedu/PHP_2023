<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Vp\App\Application\Contract\ImportDataInterface;
use Vp\App\Infrastructure\Exception\MethodNotFound;

class CommandImport implements CommandInterface
{
    private ImportDataInterface $importData;

    public function __construct(ImportDataInterface $importData)
    {
        $this->importData = $importData;
    }

    /**
     * @throws MethodNotFound
     */
    public function run(string $object): void
    {
        $result = match ($object) {
            'positions.csv' => $this->importData->import($object, 'positions'),
            'employees.csv' => $this->importData->import($object, 'employees'),
            'timesheet.csv' => $this->importData->import($object, 'timesheet'),
            default => $this->importData->importDefault(),
        };

        echo $result->getMessage();
    }
}
