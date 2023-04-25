<?php

declare(strict_types=1);

namespace Console\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Exceptions\MethodNotFound;
use Services\Container;

class CommandList implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws MethodNotFound
     */
    public function run(string $object): void
    {
        $listData = Container::getInstance()->get('Services\ListData');

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
