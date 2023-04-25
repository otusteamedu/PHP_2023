<?php

declare(strict_types=1);

namespace Console\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Exceptions\MethodNotFound;
use Services\Container;

class CommandReport implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws MethodNotFound
     */
    public function run(string $object): void
    {
        $reportData = Container::getInstance()->get('Services\ReportData');

        switch ($object) {
            case 'top5longTasks':
            case 'top5costTasks':
            case 'top5employees':
                $result = $reportData->report($object);
                $result->show();
                break;
            default:
                echo 'The object name is incorrect' . PHP_EOL;
        }
    }
}
