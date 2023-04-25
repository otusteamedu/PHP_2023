<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

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
                $result->show();
                break;
            default:
                echo 'The object name is incorrect' . PHP_EOL;
        }
    }
}
