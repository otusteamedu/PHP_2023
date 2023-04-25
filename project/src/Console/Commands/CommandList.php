<?php

declare(strict_types=1);

namespace Vp\App\Console\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\Exceptions\MethodNotFound;
use Vp\App\Services\Container;

class CommandList implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws MethodNotFound
     */
    public function run(string $object): void
    {
        $listData = Container::getInstance()->get('Vp\App\Services\ListData');

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
