<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\Application\UseCase\Container;

class CommandRemove implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(string $object): void
    {
        $removeData = Container::getInstance()->get('Vp\App\Application\UseCase\RemoveData');
        $result = $removeData->remove((int)$object);

        echo $result->getMessage();
    }
}
