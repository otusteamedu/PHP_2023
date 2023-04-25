<?php

declare(strict_types=1);

namespace Console\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Services\Container;

class CommandRemove implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(string $object): void
    {
        $removeData = Container::getInstance()->get('Services\RemoveData');
        $result = $removeData->remove((int)$object);

        echo $result->getMessage();
    }
}
