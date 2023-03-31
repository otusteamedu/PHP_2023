<?php

declare(strict_types=1);

namespace Vp\App\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\Event\AddParams;
use Vp\App\Event\EventAdd;
use Vp\App\Exceptions\CommandArguments;
use Vp\App\Services\Container;

class CommandAdd implements CommandInterface
{
    const COUNT_ARGUMENTS = 5;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws CommandArguments
     */
    public function run(?array $argv): void
    {
        if (count($argv) < self::COUNT_ARGUMENTS) {
            throw new CommandArguments('The number of arguments cannot be less than ' . self::COUNT_ARGUMENTS);
        }

        $addParams = (new AddParams(count($argv)))->setParams($argv);
        $eventAdd = Container::getInstance()->get(EventAdd::class);
        $result = $eventAdd->work($addParams);
        $result->print();
    }
}
