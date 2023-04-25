<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\Application\UseCase\Container;

class CommandGet implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(string $object): void
    {
        $getData = Container::getInstance()->get('Vp\App\Application\UseCase\GetData');
        $result = $getData->get($object);

        if ($result->isSuccess()) {
            $result->show();
            return;
        }

        echo $result->getMessage();
    }
}
