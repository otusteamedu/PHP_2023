<?php

declare(strict_types=1);

namespace Console\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Services\Container;

class CommandGet implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(string $object): void
    {
        $getData = Container::getInstance()->get('Services\GetData');
        $result = $getData->get($object);

        if ($result->isSuccess()) {
            $result->show();
            return;
        }

        echo $result->getMessage();
    }
}
