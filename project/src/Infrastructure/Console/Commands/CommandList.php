<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\Application\UseCase\Container;
use Vp\App\Infrastructure\Exception\MethodNotFound;

class CommandList implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws MethodNotFound
     */
    public function run(string $object): void
    {
        $listData = Container::getInstance()->get('Vp\App\Application\UseCase\ListData');

        switch ($object) {
            case 'employee':
                $result = $listData->list($object);
                $result->show();
                break;
            default:
                echo 'The object name is incorrect' . PHP_EOL;
        }
    }
}
