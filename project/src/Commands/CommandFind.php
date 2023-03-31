<?php

declare(strict_types=1);

namespace Vp\App\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\Event\FindParams;
use Vp\App\Event\EventFind;
use Vp\App\Exceptions\CommandArguments;
use Vp\App\Services\Container;

class CommandFind implements CommandInterface
{
    const COUNT_ARGUMENTS = 3;

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

        $findParams = (new FindParams(count($argv)))->setParams($argv);
        $eventFind = Container::getInstance()->get(EventFind::class);
        $result = $eventFind->work($findParams);
        $result->print();
    }
}
